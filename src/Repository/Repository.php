<?php

require APP_DIR.'db/Connect.php';
require SRC_DIR.'Repository/PageRepository.php';

/**
 * Class Repository
 */
class Repository
{
    /** @var  PDO */
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connect::getInstance()->getConnection();
    }

    public function getRepositoryByName($repoName)
    {
        $className = $repoName.'Repository';

        return new $className($this->pdo);
    }


}