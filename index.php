<?php
require __DIR__.'/vendor/autoload.php';

use \Leone\Promos\Http\Router;
use \Dotenv\Dotenv;

$dominio = 'http';
$dominio .= !empty($_SERVER['HTTPS'])?'s':'';
$dominio .= '://'.$_SERVER['HTTP_HOST'];

$_SERVER['HOST'] = $dominio;
unset($dominio);

$router = new Router;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require __DIR__.'/routes/pages.php';
require __DIR__.'/routes/api.php';

$router->run()->sendResponse();
