<?php

use \Leone\Promos\Controller\Pages\Ofertas;
use \Leone\Promos\Http\Response;

define('URL', 'https://redir.lomadee.com/v2/deeplink?sourceId='.$_ENV['SOURCE_ID_LOMADEE'].'&url=');

define('SITE', 'https://ofertas.leone.tec.br/');
 
$router->get('/', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', SITE);
    return $redirect;
  }]);

$router->get('/listore', [
  function (){
    return new Response(200, file_get_contents(__DIR__.'/../resources/html/listore.html'));
  }]);
  
$router->get('/amazon/{product_id}', [
  function ($product_id){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.amazon.com.br/gp/product/'.$product_id);
    return $redirect;
  }]);

$router->get('/magalu/{product_id}', [
  function ($product_id){
    $redirect = new Response(303);
    $redirect->addHeader('Location', 'https://www.magazinevoce.com.br/magazineofertasleone/p/'.$product_id);
    return $redirect;
  }]);

$router->get('/americanas/{product_id}', [
  function ($product_id){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.americanas.com.br/produto/'.$product_id);
    return $redirect;
  }]);


$router->get('/shoptime/{product_id}', [
  function ($product_id){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.shoptime.com.br/produto/'.$product_id);
    return $redirect;
  }]);


$router->get('/submarino/{product_id}', [
  function ($product_id){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.submarino.com.br/produto/'.$product_id);
    return $redirect;
  }]);
  
$router->get('/aliexpress/{product_id}', [
  function ($product_id){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://pt.aliexpress.com/item/'.$product_id.'.html');
    return $redirect;
  }]);
  
$router->get('/amazon', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.amazon.com.br/');
    return $redirect;
  }]);

$router->get('/magalu', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', 'https://www.magazinevoce.com.br/magazineofertasleone/');
    return $redirect;
  }]);

$router->get('/americanas', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.americanas.com.br');
    return $redirect;
  }]);

$router->get('/shoptime', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.shoptime.com.br');
    return $redirect;
  }]);

$router->get('/submarino', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://www.submarino.com.br');
    return $redirect;
  }]);
  
$router->get('/aliexpress', [
  function (){
    $redirect = new Response(303);
    $redirect->addHeader('Location', URL.'https://pt.aliexpress.com');
    return $redirect;
  }]);

$router->get('/c/{cupom_id}', [
  function ($cupom_id){
    $page = ceil((abs(intval($cupom_id))+1)/18);
    $redirect = new Response(303);
    $redirect->addHeader('Location', SITE.'cupons/'.$page.'#cupom_'.$cupom_id);
    return $redirect;
  }]);

$router->get('/o/{cat_id}_{page}_{oferta_id}', [
  function ($cat_id, $page, $oferta_id){
    $redirect = new Response(303);
    $redirect->addHeader('Location', SITE.Ofertas::process(abs(intval($cat_id)), abs(intval($page)), abs(intval($oferta_id))));
    return $redirect;
  }]);
