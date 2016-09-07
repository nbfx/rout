<?php
$app->get('/', '\MainController:index')->setName('index');
$app->get('/api/get-callback', '\MainController:index')->setName('post-ajax-callback');
$app->get('/{path}', '\MainController:index');