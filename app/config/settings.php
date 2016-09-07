<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'mode' => 'development',

        'logger' => [
            'name' => 'app',
            'path' => APP_DIR.'/logs/app.log',
        ],
        'factory' => [
            'name' => 'default_rout',
        ],
        'twig' => [
            'templates' => WEB_DIR.'static/templates/',
            'cache' => false,
            'debug' => true,
        ],
    ],
];
