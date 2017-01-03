<?php

define('__APP_ROOT__', dirname(__DIR__));

require __APP_ROOT__ . '/vendor/autoload.php';

use Hero\Core\App;

$http = new App();

$http->on('GET', 'path/to/action/(\w+)', 'Hero\App\HeroController@action');

$http->handler();