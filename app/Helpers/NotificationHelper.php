<?php
namespace App\Helpers;

use Minishlink\WebPush;
use App\Models\Notification;

/**
 * Realiza o envio da notificação
 */
class NotificationHelper{
  private $auth;
  
  /*
   * Preenche a variável com os parâmetros de autenticação
   */
  public function __construct(){
    $this->auth = ['VAPID' => [
      'subject' => env('APP_URL'),
      'publicKey' => env('VAPID_PUBLIC_KEY'),
      'privateKey' => env('VAPID_PRIVATE_KEY')]
      ];
  }
  
  /**
   * Método para enviar uma notificação para um usuário
   * @params array $subscription $payload
   * @return boolean
   */
  public function sendOneNotification(array $subscription = [], array $payload = ['msg' => 'Agora você será notificado a cada promoção imperdível! Toque para editar suas preferências ;)', 'title' => 'Notificações Ativadas ;)', 'link' => '/notificacoes']): bool{
    if (empty($subscription)) {
      $subscription = Notification::where('id', 0)->first();
    }
    
    $subscription = WebPush\Subscription::create(["endpoint" => $subscription['endpoint'], "keys" => ['p256dh' => $subscription['p256dh'], 'auth' => $subscription['auth']]]);
    
    $webPush = new WebPush\WebPush($this->auth);
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
  public function sendManyNotifications(array $subscriptions, array $payload): bool{
    
    for ($i=0;!empty($subscriptions[$i]); $i++) {
      $notifications[$i]['subscription'] = WebPush\Subscription::create(["endpoint" => $subscriptions[$i]['endpoint'], "keys" => ['p256dh' => $subscriptions[$i]['p256dh'], 'auth' => $subscriptions[$i]['auth']]]);
      $notifications[$i]['payload'] = json_encode($payload);
    }
    
    $webPush = new WebPush\WebPush($this->auth);
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
        Notification::where('endpoint', $endpoint)->delete();
        $result = false;
      }
    }
    return $result;
  }
  
}