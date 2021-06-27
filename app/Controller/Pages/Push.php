<?php
namespace Promos\Controller\Pages;

use \Promos\Utils;
use \Promos\Controller\Notify\Send;
use \Exception;

/**
 * Classe responsável por gerar a página de gerenciamento de notificações
 */
class Push extends Page{
  
  /**
   * Método responsável por processar o dados da subscrição do usuário.
   * @return array
   */
  public static function setRegister(){
    $response['success'] = false;
    try{
      $dado = json_decode(file_get_contents('php://input'), true);
      $p256dh = $dado['subscription']['keys']['p256dh']??'';
      $auth = $dado['subscription']['keys']['auth']??'';
      $endpoint = $dado['subscription']['endpoint']??'';
      $token = $dado['token']??'';
      
      if (empty($dado['action']) || empty($endpoint) || strlen($p256dh)<87 || strlen($p256dh)>88 || strlen($auth)<22 || strlen($auth)>24 || strlen($token)<20) {
        throw new Exception('Dados obrigatórios não foram recebidos!');
      }
      
      $recaptcha = new Utils\Recaptcha($token);
      
      if ($recaptcha->isOrNotV3()) {
        throw new Exception('Talvez você seja um robô, tente novamente mais tarde!');
      }
      
      if ($dado['action']==='remove') {
        $db = new Utils\Database('notify');
        $values = ['col' => 'endpoint', 'val' => $endpoint];
        $db->delete($values);
        $response['success'] = true;
      }elseif ($dado['action']==='add') {
        $db = new Utils\Database('notify');
        $values = ['col' => 'endpoint', 'val' => $endpoint];
        $dados = $db->select($values)->fetch();
        if (empty($dados)) {
          $notify = new Send;
          $values = [
            'auth' => $auth,
            'p256dh' => $p256dh,
            'endpoint' => $endpoint
          ];
          $sucess = $notify->oneNotification($values);
          if(!$sucess){
            throw new Exception('Não foi possível enviar a notificação de confirmação!');
          }
          $db->insert($values);
          $response['success'] = true;
        }else{
          throw new Exception('Tente novamente!');
        }
      }else{
        throw new Exception('Ação desconhecida!');
      }
    } catch(Exception $e){
      $response['success'] = false;
      $erro = $e->getMessage();
      if (!empty($erro)){$response['erro'] = $erro;}
    } finally{
      return $response;
    }
  }
  
  public static function send(){
    if (empty($_GET['valor']) and empty($_GET['comissao'])) {
      throw new Exception('', 404);
    } else {
      $payload = ['msg' => 'Sua venda foi de R$ '.number_format(intval($_GET['valor']), 2, ',', '.').', sua comissão será de R$ '.number_format(intval($_GET['comissao']), 2, ',', '.'), 'title' => 'Você fez uma nova venda!', 'link' => '/'];
      $notify = new Send;
      $notify->oneNotification('', $payload);
    }
  }
  
  public static function get(){
    $content = Utils\View::render('pages/notificacoes');
      
    return Page::getPage('Notificações', $content);
  }
  
  public static function sendAll(){
    $result['success'] = false;
    $key = $_POST['key']??'';
    $msg = $_POST['content']??'';
    $title = $_POST['title']??'';
    $link = $_POST['link']??'';
    $img = $_POST['img']??'';
    try{
      if ($key !== '{secret-key-api}') {
        throw new Exception('Acesso Negado');
      }
      
      if (empty($link) || empty($title) || empty($msg)) {
        throw new Exception('Parâmetros vazios');
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
    }catch (Exception $e){
      $result['erro'] = $e->getMessage();
    }finally{
      return $result;
    }
  }
}
