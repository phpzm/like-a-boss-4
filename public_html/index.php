<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Hero\App\HeroController;
use Hero\Core\App;

$http = new App([
    'separator' => '->',
    'labels' => true
]);

$http
    ->on('GET', '/path/to/action/:upa', 'Hero\App\HeroController->action', ['labels' => false])
    ->on('GET', '/:path*', function (HeroController $heroController, $path) {
        return $heroController->home($path);
    });

$http->handler();