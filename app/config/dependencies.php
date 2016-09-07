<?php

use Interop\Container\ContainerInterface as Container;

$container['logger'] = function (Container $container) {
    $settings = $container->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));

    return $logger;
};

$container['repository'] = function(Container $container) {
    require SRC_DIR.'Repository/Repository.php';

    return new Repository();
};

$container['twig'] = function (Container $container) {
    $settings = $container->get('settings')['twig'];
    $path = $settings['templates'];
    unset($settings['templates']);
    $view = new \Slim\Views\Twig($path, $settings);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

/*$container['em'] = function ($container) {
    $settings = $container->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};*/
