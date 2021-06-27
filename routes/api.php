<?php

require __DIR__.'/api/v1/default.php';
  
$router->post('/api{}', [
  function (){
    return new Response(404, ['error' => 404, 'message' => 'Não encontrado'], 'application/json');
  }]);

$router->get('/api{}', [
  function (){
    return new Response(404, ['error' => 404, 'message' => 'Não encontrado'], 'application/json');
  }]);
