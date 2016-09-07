<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(-1);
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

const PROJECT_DIR =  __DIR__.'/../';
const APP_DIR = PROJECT_DIR.'app/';
const SRC_DIR = PROJECT_DIR.'src/';
const WEB_DIR = PROJECT_DIR.'web/';
const CONFIG_DIR = APP_DIR.'config/';

require PROJECT_DIR.'vendor/autoload.php';

session_start();
use \Interop\Container\ContainerInterface as Container;
use \Slim\Http\Response as Response;
use Slim\Http\Request as Request;
use Interop\Container\Exception as Exception;
// Instantiate the app
$settings = require CONFIG_DIR.'settings.php';
//require PROJECT_DIR.'src/model/Factory.php';

$app = new \Slim\App($settings);
$container = $app->getContainer();

$container['errorHandler'] = function (Container $container) {
    return function (Request $request, Response $response, $exception) use ($container) {
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!<br/>')
            ->write('Code: '.$exception->getCode().'<br/>'.$exception->getMessage());
    };
};


$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        return $response->withRedirect((string)$uri, 301);
    }

    return $next($request, $response);
});

require CONFIG_DIR.'dependencies.php';
require CONFIG_DIR.'routes.php';
require SRC_DIR . 'Controller/MainController.php';

$app->run();
