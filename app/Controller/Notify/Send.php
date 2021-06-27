<?php

namespace Promos\Controller\Notify;

use \Minishlink\WebPush;
use \Promos\Utils\Database;

/**
 * Class responsável pelo envio da notificação
 */
class Send{
  
  private $privateKey;
  private $publicKey;
  
  public function __construct(){
    $this->privateKey = file_get_contents(__DIR__.'/Private.key');
    $this->publicKey = file_get_contents(__DIR__.'/Public.key');
  }
  
  /**
   * Método para enviar uma notificação para um usuário
   * @params array $subscription $payload
   * @return boolean
   */
  public function oneNotification($subscription, $payload = ['msg' => 'Agora você será notificado a cada promoção imperdível!', 'title' => 'Notificações Ativadas ;)', 'link' => '/notificacoes']){
    if (empty($subscription)) {
      $subscription = json_decode(file_get_contents(__DIR__.'/subscription.json'), true);
    }
    
    $subscription = WebPush\Subscription::create(["endpoint" => $subscription['endpoint'], "keys" => ['p256dh' => $subscription['p256dh'], 'auth' => $subscription['auth']]]);
    
    $auth = ['VAPID' => [
      'subject' => 'https://ofertas.leone.tec.br',
      'publicKey' => $this->publicKey,
      'privateKey' => $this->privateKey]
      ];
    
    
    $webPush = new WebPush\WebPush($auth);
    $webPush->setAutomaticPadding(false);
    $webPush->setReuseVAPIDHeaders(true);
    $report = $webPush->sendOneNotification($subscription,json_encode($payload));
    
    return $report->isSuccess();
  }
  
  
  /**
   * Método para enviar notificações para vários usuários
   * @params array $subscription $payload
   * @return boolean
   */
  public function manyNotifications($subscriptions, $payload){
    
    for ($i=0;!empty($subscriptions[$i]); $i++) {
      $notifications[$i]['subscription'] = WebPush\Subscription::create(["endpoint" => $subscriptions[$i]['endpoint'], "keys" => ['p256dh' => $subscriptions[$i]['p256dh'], 'auth' => $subscriptions[$i]['auth']]]);
      $notifications[$i]['payload'] = json_encode($payload);
    }
    
    $auth = ['VAPID' => [
      'subject' => 'https://ofertas.leone.tec.br',
      'publicKey' => $this->publicKey,
      'privateKey' => $this->privateKey]
      ];
    
    
    $webPush = new WebPush\WebPush($auth);
    $webPush->setAutomaticPadding(false);
    $webPush->setReuseVAPIDHeaders(true);
    foreach ($notifications as $notification) {
      $webPush->queueNotification(
        $notification['subscription'],
        $notification['payload']
      );
    }
  
    $result = true;
    foreach ($webPush->flush() as $report) {
      if (!$report->isSuccess()) {
        $endpoint = $report->getRequest()->getUri()->__toString();
        $db = new Database('notify');
        $values = ['col' => 'endpoint', 'val' => $endpoint];
        $db->delete($values);
        $result = false;
      }
    }
    return $result;
  }
  
}