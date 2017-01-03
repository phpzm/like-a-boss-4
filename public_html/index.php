<?php

define('__APP_ROOT__', dirname(__DIR__));

require __APP_ROOT__ . '/vendor/autoload.php';

use Hero\Core\App;
use Hero\Core\Router;
use Hero\Http\Request;
use Hero\Http\Response;

$app = new App();

$app->http(function (Router $router) {

    $router
        ->on('GET', 'path/to/action', function (Request $request, Response $response, $parameters) {

            $heroController = new Hero\App\HeroController($request, $response);

            return $heroController->action($parameters);
        })
        ->post('/(\w+)/(\w+)/(\w+)', function ($module, $class, $method) {
            var_dump([$module, $class, $method]);
        })
        ->get('/(.*)', function ($uri) {
            var_dump($uri);
        });

    return $router;
});

$app->handler();