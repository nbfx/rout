<?php

/**
 * Class Page
 */
class Page
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $path;
    /**
     * @var integer
     */
    private $level;
    /**
     * @var ArrayCollection
     */
    private $children;
    /**
     * @var integer
     */
    private $parent_id;
    /**
     * @var string
     */
    private $alias;
    /**
     * @var string
     */
    private $body;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $classes;
    /**
     * @var string
     */
    private $template;
    /**
     * @var boolean
     */
    private $is_enabled;
    /**
     * @var boolean
     */
    private $is_available_directly;
    /**
     * @var boolean
     */
    private $is_only_for_registered;
    /**
     * @var boolean
     */
    private $is_deleted;
    /**
     * @var DateTime
     */
    private $created_at;
    /**
     * @var DateTime
     */
    private $updated_at;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title = '')
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param int $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias = '')
    {
        $this->alias = strlen($alias) ? $alias : $this->getName();
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body = '')
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description = '')
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @param string $classes
     */
    public function setClasses($classes = '')
    {
        $this->classes = $classes;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {


        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return boolean
     */
    public function isIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * @param boolean $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }


}