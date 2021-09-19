<?php

namespace Leone\Promos\Controller\Notify;

use Minishlink\WebPush;
use Leone\Promos\Utils\Database;

/**
 * Class responsável pelo envio da notificação
 */
class Send{
  
  private $privateKey;
  private $publicKey;
  
  public function __construct(){
    $this->privateKey = $_ENV['VAPID_PRIVATE_KEY'];
    $this->publicKey = $_ENV['VAPID_PUBLIC_KEY'];
  }
  
  /**
   * Método para enviar uma notificação para um usuário
   * @params array $subscription $payload
   * @return boolean
   */
  public function oneNotification(array $subscription, array $payload = ['msg' => 'Agora você será notificado a cada promoção imperdível!', 'title' => 'Notificações Ativadas ;)', 'link' => '/notificacoes']) : bool{
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
  public function manyNotifications(array $subscriptions, array $payload) : bool{
    
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
        $content = "\n\n".$endpoint.'==='.$report->getReason();
        file_put_contents('resources/logs/fail_notify.txt', $content, FILE_APPEND);
        $result = false;
      }
    }
    return $result;
  }
  
}