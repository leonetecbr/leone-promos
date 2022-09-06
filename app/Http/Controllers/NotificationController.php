<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers;
use App\Models\Notification;
use ErrorException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends Controller
{

    /**
     * Retorna as preferências de notificação do usuário
     * @param Request $request
     * @return array
     */
    #[Route('/prefer/get')]
    public static function getPrefer(Request $request): array
    {
        if ($request->filled('endpoint')) {
            $endpoint = $request->input('endpoint');
            $prefer = Notification::where('endpoint', $endpoint)->first();

            if (empty($prefer)) {
                return ['success' => false, 'message' => 'Usuário não encontrado! Desative as notificações, ative e tente novamente.'];
            }

            $prefer = $prefer->toArray();

            $pref = [
                $prefer['p1'],
                $prefer['p2'],
                $prefer['p3'],
                $prefer['p4'],
                $prefer['p5'],
                $prefer['p6'],
                $prefer['p7'],
                $prefer['p8'],
                $prefer['p9']
            ];

            return [
                'success' => true,
                'pref' => $pref
            ];
        } else {
            return ['success' => false, 'message' => 'Endpoint do usuário não informado!'];
        }
    }

    /**
     * Define as preferências de notificação do usuário
     * @param Request $request
     * @return array
     */
    #[Route('/prefer/set', name: 'prefer.set')]
    public static function setPrefer(Request $request): array
    {
        if ($request->filled('endpoint')) {
            $endpoint = $request->input('endpoint');
            $token = $request->input('g-recaptcha-response');

            if (empty($token)) {
                return ['success' => false, 'message' => 'Talvez você seja um robô!'];
            }

            $recaptcha = new Helpers\RecaptchaHelper($request, $token);

            if ($recaptcha->isOrNot()) {
                return ['success' => false, 'message' => 'Talvez você seja um robô! :)'];
            }

            $prefer = Notification::where('endpoint', $endpoint)->first();

            if (empty($prefer)) {
                return ['success' => false, 'message' => 'Usuário não encontrado! Desative as notificações, ative e tente novamente.'];
            }

            $prefer->p1 = $request->filled('p1');
            $prefer->p2 = $request->filled('p2');
            $prefer->p3 = $request->filled('p3');
            $prefer->p4 = $request->filled('p4');
            $prefer->p5 = $request->filled('p5');
            $prefer->p6 = $request->filled('p6');
            $prefer->p7 = $request->filled('p7');
            $prefer->p8 = $request->filled('p8');
            $prefer->p9 = $request->filled('p9');

            $prefer->save();

            return [
                'success' => true, 'message' => 'Preferências salvas com sucesso!'
            ];
        } else {
            return ['success' => false, 'message' => 'Endpoint do usuário não informado!'];
        }
    }

    /**
     * Cadastra, atualiza e exclui credenciais para envio de notificações push
     * @param Request $request
     * @return array
     * @throws ErrorException
     */
    #[Route('/notificacoes/manage')]
    public function userManage(Request $request): array
    {
        $response['success'] = false;
        try {
            $validator = Validator::make($request->all(), [
                'action' => 'required',
                'subscription.endpoint' => 'required',
                'subscription.keys.p256dh' => 'required|size:87',
                'subscription.keys.auth' => 'required|size:22',
                'token' => 'required|min:20'
            ]);

            if ($validator->fails()) {
                throw new RequestException($validator->errors()->all()[0], 400);
            }

            $p256dh = $request->input('subscription.keys.p256dh');
            $auth = $request->input('subscription.keys.auth');
            $endpoint = $request->input('subscription.endpoint');
            $token = $request->input('token');
            $action = $request->input('action');

            $recaptcha = new Helpers\RecaptchaHelper($request, $token);

            if ($recaptcha->isOrNot()) {
                throw new RequestException('Talvez você seja um robô, tente novamente mais tarde!');
            }

            if ($action === 'update') {
                if (empty(Notification::where('endpoint', $endpoint)->first())) {
                    $notify = new Helpers\NotificationHelper;

                    $notification = new Notification;
                    $notification->auth = $auth;
                    $notification->p256dh = $p256dh;
                    $notification->endpoint = $endpoint;
                    $success = $notify->sendOneNotification(['auth' => $auth, 'p256dh' => $p256dh, 'endpoint' => $endpoint], [
                        'title' => 'Vai uma promoção ai?',
                        'msg' => 'Que tal vim conferir as nossas melhores promoções? Vem aproveitar!',
                        'link' => '/'
                    ]);
                    if (!$success) {
                        throw new RequestException('Não foi possível enviar a notificação de confirmação!');
                    }
                    $notification->save();
                }
                $response['success'] = true;
            } elseif ($action === 'remove') {
                Notification::where('endpoint', $endpoint)->delete();
                $response['success'] = true;
            } elseif ($action === 'add') {
                if (empty(Notification::where('endpoint', $endpoint)->first())) {
                    $notify = new Helpers\NotificationHelper;

                    $notification = new Notification;
                    $notification->auth = $auth;
                    $notification->p256dh = $p256dh;
                    $notification->endpoint = $endpoint;
                    $success = $notify->sendOneNotification(['auth' => $auth, 'p256dh' => $p256dh, 'endpoint' => $endpoint]);
                    if (!$success) {
                        throw new RequestException('Não foi possível enviar a notificação de confirmação!');
                    }
                    $notification->save();
                    $response['success'] = true;
                } else {
                    throw new RequestException('Tente novamente!');
                }
            } else {
                throw new RequestException('Ação desconhecida!');
            }
        } catch (RequestException $e) {
            $response['success'] = false;
            $erro = $e->getMessage();
            if (!empty($erro)) {
                $response['erro'] = $erro;
            }
        } finally {
            return $response;
        }
    }

    /**
     * Envia notificações quando uma venda é realizada
     * @param Request $request
     * @param string $key
     * @return array
     * @throws ErrorException
     */
    #[Route('/api/v1//{key}/postback')]
    public function postback(Request $request, string $key): array
    {
        $result['success'] = false;
        try {
            if ($key !== env('KEY_POSTBACK')) {
                throw new RequestException('Acesso Negado', 403);
            }

            $validator = Validator::make($request->all(), [
                'valor' => 'required|numeric',
                'comissao' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                throw new RequestException($validator->errors()->all()[0], 400);
            }

            $value = $request->input('valor');
            $commission = $request->input('comissao');
            $payload = ['msg' => 'Sua venda foi de R$ ' . number_format(floatval($value), 2, ',', '.') . ', sua comissão será de R$ ' . number_format(floatval($commission), 2, ',', '.'), 'title' => 'Você fez uma nova venda!', 'link' => '/'];
            $notify = new Helpers\NotificationHelper;
            $result['success'] = $notify->sendOneNotification([], $payload);
            $result['code'] = 200;
        } catch (RequestException $e) {
            $result['message'] = $e->getMessage();
            $result['code'] = $e->getCode();
        } finally {
            return $result;
        }
    }

    /**
     * Gera a página de envio de notificações
     * @returns View
     */
    #[Route('/notification', name: 'notification.new')]
    public function getAdmin(): View
    {
        return view('admin.notification');
    }

    /**
     * Envia a(s) notificação(ões) para o(s) destinatário(s)
     * @param Request $request
     * @return RedirectResponse
     * @throws ErrorException
     * @throws ValidationException
     */
    #[Route('/notification/send', name: 'notification.send')]
    public function send(Request $request): RedirectResponse
    {
        $todos = $request->input('para', false);

        $dados = $this->validate($request, [
            'title' => 'required',
            'link' => 'required',
            'content' => 'required'
        ]);

        $payload = [
            'msg' => $dados['content'],
            'title' => $dados['title'],
            'link' => $dados['link']
        ];

        if (($request->filled('image'))) {
            $payload['img'] = $request->input('image');
        }

        $notification = new Helpers\NotificationHelper;

        if (!$todos) {
            if ($request->filled('para2')) {
                $dados = $this->validate($request, [
                    'para2' => 'required|integer'
                ], ['para2.required' => 'Digite o id que receberá a notificação!', 'para2.integer' => 'O id precisa ser um número!',]);
                $id = $dados['para2'];
                $subscription = Notification::find($id);
                if (empty($subscription)) {
                    return redirect()->back()->withErrors([
                        'para2' => ['Destinatário não encontrado!']
                    ])->withInput();
                }
                $to = $subscription->toArray();
                $success = $notification->sendOneNotification($to, $payload);
            } else {
                for ($i = 1; $i <= 9; $i++) {
                    if ($request->filled('p' . $i)) {
                        if (empty($where)) {
                            $where = 'p' . $i . ' = 1';
                        } else {
                            $where .= ' or p' . $i . ' = 1';
                        }
                    }
                }

                if (empty($where)) {
                    return redirect()->back()->withErrors([
                        'prefer' => ['Preferência não informada!']
                    ])->withInput();
                } else {
                    $subscriptions = Notification::whereRaw($where)->get();
                    foreach ($subscriptions as $subscription) {
                        $to[] = $subscription->toArray();
                    }
                    $success = $notification->sendManyNotifications($to, $payload);
                }
            }
        } else {
            $to = [];
            $subscriptions = Notification::all();
            foreach ($subscriptions as $subscription) {
                $to[] = $subscription->toArray();
            }
            $success = $notification->sendManyNotifications($to, $payload);
        }

        if (!$success) {
            return redirect()->back()->withErrors(['para2' => ['Não foi possível enviar a mensagem para 1 ou mais destinatários!']]);
        } else {
            return redirect()->back()->with(['sender' => 'Notificação enviada com sucesso a todos os destinatários!']);
        }
    }

    /**
     * Gera o histórico de notificações enviadas
     * @returns View
     */
    #[Route('/notificacoes', name: 'notificacoes')]
    public function get(): View
    {
        return view('notifications');
    }
}
