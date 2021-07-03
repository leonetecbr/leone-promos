<?php

namespace Promos\Controller\Api;

use \Promos\Controller\Notify\Send;
use \Promos\Utils;
use \Exception;

/**
 * Gerencia as notificações push enviadas pela Api
 */
class Push extends Api{
  
  /**
   * Envia uma notificação para todos os usuários cadastrados
   */
  public static function sendAll(){
    $result['success'] = false;
    $msg = $_POST['content']??'';
    $title = $_POST['title']??'';
    $link = $_POST['link']??'';
    $img = $_POST['img']??'';
    try{
      if (!Api::auth()) {
        throw new Exception('Acesso Negado', 403);
      }
      
      if (empty($link) || empty($title) || empty($msg)) {
        throw new Exception('Parâmetros vazios', 400);
      }
      
      $db = new Utils\Database('notify');
      $dados = $db->select()->fetchAll();
      $payload = [
        'msg' => $msg, 
        'title' => $title,
        'link' => $link
        ];
      if (!empty($img)) {
        $payload['img'] = $img;
      }
      $notify = new Send;
      $result['success'] = $notify->manyNotifications($dados, $payload);
      $result['code'] = 200;
    }catch (Exception $e){
      $result['message'] = $e->getMessage();
      $result['code'] = $e->getCode();
    }finally{
      return $result;
    }
  }
  
  /*
  *
  */
  public static function sendAdmin($key){
    $result['success'] = false;
    try{
      if ($key !== $_ENV['KEY_POSTBACK']) {
        throw new Exception('Acesso Negado', 403);
      }
      
      if (empty($_GET['valor']) || empty($_GET['comissao'])) {
        throw new Exception('Parâmetros vazios', 400);
      }
      $payload = ['msg' => 'Sua venda foi de R$ '.number_format(floatval($_GET['valor']), 2, ',', '.').', sua comissão será de R$ '.number_format(floatval($_GET['comissao']), 2, ',', '.'), 'title' => 'Você fez uma nova venda!', 'link' => '/'];
      $notify = new Send;
      $result['success'] = $notify->oneNotification('', $payload);
      $result['code'] = 200;
    }catch (Exception $e){
      $result['message'] = $e->getMessage();
      $result['code'] = $e->getCode();
    }finally{
      return $result;
    }
  }
}