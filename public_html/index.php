<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Hero\App\HeroController;
use Hero\Core\App;

$http = new App([
    'separator' => '->', // used to concat class & method what will be called
    'labels' => true // exact match of parameter name of route with parameter name of callback of route
]);

$http
    ->on('GET', '/', function () {
        return 'Made with &hearts; by @wilcorrea';
    })
    ->on('GET', '/path/to/action/:upa',
        'Hero\App\HeroController->action', ['labels' => false]
    )
    ->on('GET', '/:path*', function (HeroController $heroController, $path) {
        return $heroController->home($path);
    });

$http->handler();
