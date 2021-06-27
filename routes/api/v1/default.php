<?php

use \Promos\Http\Response;
use \Promos\Controller\Api;

$router->post('/api/v1/sendAll', [
  function (){
    $result = Api\Push::sendAll();
    return new Response($result['code'], $result, 'application/json');
  }]);

$router->get('/api/v1/{key}/postback', [
  function ($key){
    $result = Api\Push::sendAdmin($key);
    return new Response($result['code'], $result, 'application/json');
  }]);
