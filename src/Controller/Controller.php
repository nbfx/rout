<?php

use Interop\Container\ContainerInterface as Container;

/**
 * Class Controller
 */
class Controller
{
    /** @var Container  */
    protected $container;

    /** @var  Repository */
    public $repository;

    /** @var  \Slim\Views\Twig */
    public $twig;

    /**
     * @param Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
        $this->repository = $this->container->get('repository');
        $this->twig = $this->container->get('twig');
    }

    /**
     * @return \Slim\Views\Twig
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @param $repository
     * @return Repository
     */
    public function getRepository($repository)
    {
        return $this->repository->getRepositoryByName($repository);
    }
}