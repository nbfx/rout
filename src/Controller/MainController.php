<?php

require 'Controller.php';

use Slim\Http\Request;
use Slim\Http\Response;

class MainController extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     *
     * @return \Psr\Http\Message\ResponseInterface|Response
     */
    public function index(Request $request, Response $response, $args) {
        if (empty($args['path'])) $path = 'index';
        else $path = trim($args['path'], '/');
        $pageRepository = $this->getRepository('Page');
        $page = $pageRepository->getPageWithChildren($path);
        if (!$page) {
            return $response->withStatus(404)->withHeader('Content-Type', 'text/html')->write('Page not found');
        }

        return $this->twig->render($response, $page['template'], ['page' => $page]);
    }
}
