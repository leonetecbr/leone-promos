<?php
require __DIR__.'/../vendor/autoload.php';

use Leone\Promos\Http\Router;
use Dotenv\Dotenv;

$dominio = 'http';
$dominio .= !empty($_SERVER['HTTPS'])?'s':'';
$dominio .= '://'.$_SERVER['HTTP_HOST'];

$_SERVER['HOST'] = $dominio;
unset($dominio);

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$router = new Router;

require __DIR__.'/routes/pages.php';

$router->run()->sendResponse();