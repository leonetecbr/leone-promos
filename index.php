<?php
require __DIR__.'/vendor/autoload.php';

use \Promos\Http\Router;
use \Dotenv\Dotenv;

$router = new Router;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require __DIR__.'/routes/pages.php';
require __DIR__.'/routes/api.php';

$router->run()->sendResponse();
