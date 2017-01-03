<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Hero\Core\App;

$http = new App();

$http->on('GET', 'path/to/action/(\w+)', 'Hero\App\HeroController@action');

$http->handler();