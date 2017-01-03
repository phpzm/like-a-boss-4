<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Hero\Core\App;

$http = new App();

$http
    ->on('GET', '/(.*)', 'Hero\App\HeroController@home')
    ->on('GET', '/path/to/action/(\w+)', 'Hero\App\HeroController@action');

$http->handler();