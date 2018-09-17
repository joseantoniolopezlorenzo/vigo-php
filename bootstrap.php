<?php

include __DIR__ . '/vendor/autoload.php';

use Application\Controllers\Api\Intro;
use Application\Controllers\Api\Name;
use Application\Controllers\Home;
use Vigo\App;

$app = (new App)->getContainer();

$router = $app['router'];
$router->map('GET', '', Home::class);
$router->group('/api', function ($router) {
    $router->map('GET', '', Intro::class);
    $router->map('GET', '/{name:word}/', Name::class); //->middleware(new AuthMiddleware);
});

$app['send'];
