<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\SendedNotification;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Minishlink\WebPush;

/**
 * Realiza o envio da notificação
 */
class NotificationHelper
{
    /**
     * @var array
     */
    private array $auth;

    /**
     * Preenche a variável com os parâmetros de autenticação
     */
    public function __construct()
    {
        $this->auth = [
            'VAPID' => [
                'subject' => env('APP_URL'),
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY')
            ]
        ];
    }

    /**
     * Envia uma notificação para um usuário
     * @param array $subscription
     * @param array $payload
     * @return bool
     * @throws ErrorException
     * @throws Exception
     */
    public function sendOneNotification(array $subscription = [], array $payload = ['msg' => 'Agora você será notificado a cada promoção imperdível! Toque para editar suas preferências ;)', 'title' => 'Notificações Ativadas ;)', 'link' => '/notificacoes']): bool
    {
        $id = uniqid();
        $notification = [
            'link' => $payload['link'],
            'title' => $payload['title'],
            'content' => $payload['msg'],
            'image' => $payload['img'] ?? NULL,
            'id' => $id
        ];

        if (empty($subscription)) {
            $subscription = Notification::find(0);
            $notification['by'] = 'API';
        } else if (Auth::check()) {
            $notification['by'] = Auth::user()->email;
        } else {
            $notification['by'] = 'SYS';
        }

        $this->insertParams($payload['link'], $id);

        $subscription = WebPush\Subscription::create([
            'endpoint' => $subscription['endpoint'],
            'keys' => [
                'p256dh' => $subscription['p256dh'],
                'auth' => $subscription['auth']
            ]
        ]);

        $webPush = new WebPush\WebPush($this->auth);
        $webPush->setAutomaticPadding(false);
        $webPush->setReuseVAPIDHeaders(true);
        $report = $webPush->sendOneNotification($subscription, json_encode($payload));
        if ($report->isSuccess()) {
            SendedNotification::create($notification);
            return true;
        }
        return false;
    }

    /**
     * Adiciona parâmetros de rastreio no link que vai ser enviado por notificação
     * @param string $link
     * @param string $id
     * @return string
     */
    function insertParams(string $link, string $id): string
    {
        if (str_contains($link, '#')) {
            $link = explode('#', $link, 2);
            return $link[0] . '?utm_source=push_notification&tag=' . $id . '#' . $link[1];
        } else {
            return '?utm_source=push_notification&tag=' . $id;
        }
    }

    /**
     * Envia notificações para vários usuários
     * @param array $subscriptions
     * @param array $payload
     * @return bool
     * @throws ErrorException
     * @throws Exception
     */
    public function sendManyNotifications(array $subscriptions, array $payload): bool
    {
        $id = uniqid();
        $notification = [
            'by' => Auth::user()->email,
            'link' => $payload['link'],
            'title' => $payload['title'],
            'content' => $payload['msg'],
            'image' => $payload['img'] ?? NULL,
            'id' => $id
        ];

        $this->insertParams($payload['link'], $id);

        $notifications = [];
        for ($i = 0; !empty($subscriptions[$i]); $i++) {
            $notifications[$i]['subscription'] = WebPush\Subscription::create([
                'endpoint' => $subscriptions[$i]['endpoint'],
                'keys' => [
                    'p256dh' => $subscriptions[$i]['p256dh'],
                    'auth' => $subscriptions[$i]['auth']
                ]
            ]);
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
        $sended = 0;
        foreach ($webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                $endpoint = $report->getRequest()->getUri()->__toString();
                Notification::where('endpoint', $endpoint)->delete();
                $result = false;
            } else {
                $sended++;
            }
        }

        if ($sended > 0) {
            $notification['to'] = $sended;
            SendedNotification::create($notification);
        }

        return $result;
    }
}
