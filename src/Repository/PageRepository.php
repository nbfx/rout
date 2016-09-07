<?php

/**
 * Class PageRepository
 */
class PageRepository
{
    private $stm;
    private $page;

    private $_pdo;
    private $_sqlGetItemByPath = "SELECT * FROM pages WHERE path = :path LIMIT 1;";
    private $_sqlGetItemByAlias = "SELECT * FROM pages WHERE alias = :alias LIMIT 1;";
    private $_sqlGetItemsByParent = "SELECT * FROM pages WHERE parent_id = :parent_id;";

    /**
     * @param PDO $_pdo
     */
    public function __construct(PDO $_pdo)
    {
        $this->_pdo = $_pdo;
    }

    /**
     * @param $condition
     *
     * @return bool|Page
     */
    public function get($condition)
    {
        switch(gettype($condition)) {
            case 'array': break;
            case 'object': break;
            case 'string':
                return $this->getBySingleParameter(strrpos($condition, '/') == false ? 'alias' : 'path', $condition);
        }

        return false;
    }

    /**
     * @param $field
     * @param $value
     *
     * @return mixed
     */
    private function getBySingleParameter($field, $value)
    {
        $prop = '_sqlGetItemBy'.ucfirst($field);

        $this->stm = $this->_pdo->prepare($this->$prop);
        $this->stm->bindParam(":$field", $value, PDO::PARAM_STR);
        $this->stm->execute();

        return $this->stm->fetch();
    }

    private function buildTree(array $elements, $parentId = 0) {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * @param $condition array
     *
     * @return bool|array
     */
    public function getPageWithChildren($condition)
    {
        $page = $this->get($condition);
        $this->stm = $this->_pdo->prepare("SELECT * FROM pages");
        $this->stm->execute();
        $pages = $this->stm->fetchAll();
        $page['children'] = $this->buildTree($pages, $page['id']);

        return $page;
    }
}