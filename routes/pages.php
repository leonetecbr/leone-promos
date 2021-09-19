<?php

use Leone\Promos\Controller\Pages;
use Leone\Promos\Http\Response;
use Leone\Promos\Utils;

$router->get('/', [
  function (){
    return new Response(200, Pages\Home::getHome());
  }]);

$router->get('/amazon', [
  function (){
    return new Response(200, Pages\Removed::getAmazon());
  }]);

$router->post('/newsletter', [
  function (){
    return new Response(200, Pages\Newsletter::processAjax(), 'application/json');
  }]);

$router->get('/newsletter/descadastrar', [
  function (){
    return new Response(200, Pages\Newsletter::validateKey(0));
  }]);

$router->get('/newsletter/confirmar', [
  function (){
    return new Response(200, Pages\Newsletter::validateKey(1));
  }]);

$router->get('/categorias', [
  function (){
    return new Response(200, Pages\Categorias::get());
  }]);

$router->get('/categorias/{categoria}/{int:page}', [
  function ($categoria, $page){
    return new Response(200, Pages\Categorias::process($categoria, $page));
  }]);
  
$router->get('/categorias/{categoria}', [
  function ($categoria){
    return new Response(200, Pages\Categorias::process($categoria, 1));
  }]);

$router->get('/cupons', [
  function (){
    return new Response(200, Pages\Cupons::get(1));
  }]);

$router->get('/cupons/{int:page}', [
  function ($page){
    return new Response(200, Pages\Cupons::get($page));
  }]);

$router->get('/privacidade', [
  function (){
    return new Response(200, Pages\Privacidade::getPrivacidade());
  }]);

$router->get('/cookies', [
  function (){
    return new Response(200, Pages\Cookies::getCookies());
  }]);

$router->get('/lojas', [
  function (){
    return new Response(200, Pages\Lojas::get());
  }]);

$router->get('/lojas/{loja}/{int:page}', [
  function ($loja, $page){
    return new Response(200, Pages\Lojas::process($loja, $page));
  }]);

$router->get('/lojas/{loja}', [
  function ($loja){
    return new Response(200, Pages\Lojas::process($loja, 1));
  }]);

$router->post('/search/{query}/{int:page}', [
  function ($query, $page){
    return new Response(200, Pages\Search::process(urldecode($query), $page));
  }]);

$router->post('/search/{query}', [
  function ($query){
    return new Response(200, Pages\Search::process(urldecode($query), 1));
  }]);

$router->get('/search/{query}/{page}', [
  function ($query, $page){
    return new Response(200, Pages\Search::process(urldecode($query), $page));
  }]);

$router->get('/search/{query}', [
  function ($query){
    return new Response(200, Pages\Search::process(urldecode($query), 1));
  }]);

$router->get('/redirect', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', Pages\Redirect::process());
    $redirect->sendResponse();
  }]);

$router->post('/register', [
  function (){
    return new Response(200, Pages\Push::setRegister(), 'application/json');
  }]);

$router->get('/notificacoes', [
  function (){
    return new Response(200, Pages\Push::get());
  }]);
  
$router->get('/403', [
  function (){
    throw new \Exception('', 403);
  }]);
