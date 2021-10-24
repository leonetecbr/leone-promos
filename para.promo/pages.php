<?php
define('URL', 'https://ofertas.leone.tec.br/redirect?url=');

define('SITE', 'https://ofertas.leone.tec.br');

$router->get('/', [
  function () {
    return redirect(SITE);
  }
]);

$router->get('/amazon/{product_id}', [
  function ($product_id) {
    return redirect('https://www.amazon.com.br/gp/product/' . $product_id . '?tag=leonepromos-20');
  }
]);

$router->get('/magalu/{product_id}', [
  function ($product_id) {
    return redirect('https://www.magazinevoce.com.br/magazineofertasleone/p/' . $product_id);
  }
]);

$router->get('/soub/{int:product_id}', [
  function ($product_id) {
    return redirect(URL . 'https://www.soubarato.com.br/produto/' . $product_id);
  }
]);

$router->get('/americanas/{int:product_id}', [
  function ($product_id) {
    return redirect(URL . 'https://www.americanas.com.br/produto/' . $product_id);
  }
]);

$router->get('/shoptime/{int:product_id}', [
  function ($product_id) {
    return redirect(URL . 'https://www.shoptime.com.br/produto/' . $product_id);
  }
]);


$router->get('/submarino/{int:product_id}', [
  function ($product_id) {
    return redirect(URL . 'https://www.submarino.com.br/produto/' . $product_id);
  }
]);

$router->get('/aliexpress/{int:product_id}', [
  function ($product_id) {
    return redirect(URL . 'https://pt.aliexpress.com/item/' . $product_id . '.html');
  }
]);

$router->get('/amazon', [
  function () {
    return redirect('https://www.amazon.com.br/?tag=leonepromos-20');
  }
]);

$router->get('/magalu', [
  function () {
    return redirect('https://www.magazinevoce.com.br/magazineofertasleone/');
  }
]);

$router->get('/soub', [
  function () {
    return redirect(URL . 'https://www.soubarato.com.br');
  }
]);

$router->get('/americanas', [
  function () {
    return redirect(URL . 'https://www.americanas.com.br');
  }
]);

$router->get('/shoptime', [
  function () {
    return redirect(URL . 'https://www.shoptime.com.br');
  }
]);

$router->get('/submarino', [
  function () {
    return redirect(URL . 'https://www.submarino.com.br');
  }
]);

$router->get('/aliexpress', [
  function () {
    return redirect('https://pt.aliexpress.com');
  }
]);

$router->get('/c/{int:cupom_id}', [
  function ($cupom_id) {
    $page = ceil((abs(intval($cupom_id)) + 1) / 18);
    return redirect(SITE . '/cupons/' . $page . '#cupom_' . $cupom_id);
  }
]);

$router->get('/o/{int:cat_id}_{int:page}_{int:oferta_id}', [
  function ($cat_id, $page, $oferta_id) {
    return redirect(SITE . '/' . processPage(intval($cat_id), intval($page), intval($oferta_id)));
  }
]);
