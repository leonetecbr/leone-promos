<?php
require __DIR__.'/../vendor/autoload.php';

use \Promos\Http\Router;
use \Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->safeLoad();

$router = new Router;

require __DIR__.'/routes/pages.php';

$router->run()->sendResponse();