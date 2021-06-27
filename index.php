<?php
require __DIR__.'/vendor/autoload.php';

use \Promos\Http\Router;

$router = new Router;

require __DIR__.'/routes/pages.php';
require __DIR__.'/routes/api.php';

$router->run()->sendResponse();
