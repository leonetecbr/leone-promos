<?php
namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Notification;
use Illuminate\Http\Request;
use Exception;

class NotificationController extends Controller{
  
  public function get(){
    return view('notificacoes');
  }
  
  public function register(Request $request): array{
    $response['success'] = false;
    try{
      $p256dh = $request->input('subscription.keys.p256dh');
      $auth = $request->input('subscription.keys.auth');
      $endpoint = $request->input('subscription.endpoint');
      $token = $request->input('token');
      $action = $request->input('action');
      
      if (empty($action) || empty($endpoint) || strlen($p256dh)<87 || strlen($p256dh)>88 || strlen($auth)<22 || strlen($auth)>24 || strlen($token)<20) {
        throw new Exception('Dados obrigatórios não foram recebidos!');
      }
      
      $recaptcha = new Helpers\RecaptchaHelper($request, $token);
      
      if ($recaptcha->isOrNot()) {
        throw new Exception('Talvez você seja um robô, tente novamente mais tarde!');
      }
      
      if ($action==='remove') {
        Notification::where('endpoint', $endpoint)->delete();
        $response['success'] = true;
      }elseif ($action==='add') {
        if (!Notification::where('endpoint', $endpoint)->exists()) {
          $notify = new Helpers\NotificationHelper;
          
          $notification = new Notification;
          $notification->auth = $auth;
          $notification->p256dh = $p256dh;
          $notification->endpoint = $endpoint;
          $sucess = $notify->sendOneNotification(['auth' => $auth, 'p256dh' => $p256dh, 'endpoint' => $endpoint]);
          if(!$sucess){
            throw new Exception('Não foi possível enviar a notificação de confirmação!');
          }
          $notification->save();
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
      if (!empty($erro)){
        $response['erro'] = $erro;
      }
    } finally{
      return $response;
    }
  }
  
  public function postback(Request $request, string $key): array{
    $result['success'] = false;
    try{
      if ($key !== env('KEY_POSTBACK')) {
        throw new Exception('Acesso Negado', 403);
      }
      
      $valor = $request->input('valor');
      $comissao = $request->input('comissao');
      
      if (empty($valor) || empty($comissao)) {
        throw new Exception('Parâmetros vazios', 400);
      }
      $payload = ['msg' => 'Sua venda foi de R$ '.number_format(floatval($valor), 2, ',', '.').', sua comissão será de R$ '.number_format(floatval($comissao), 2, ',', '.'), 'title' => 'Você fez uma nova venda!', 'link' => '/'];
      $notify = new Helpers\NotificationHelper;
      $result['success'] = $notify->sendOneNotification([], $payload);
      $result['code'] = 200;
    }catch (Exception $e){
      $result['message'] = $e->getMessage();
      $result['code'] = $e->getCode();
    }finally{
      return $result;
    }
  }
  
  public function getAdmin(){
    return view('admin.notification');
  }
  
  public function send(Request $request){
    $todos = $request->input('para', false);
    
    $this->validate($request, ['title' => 'required', 'link' => 'required', 'content' => 'required'], ['title.required' => 'O "Título" é obrigatório!','content.required' => 'O "Conteúdo" é obrigatório!','link.required' => 'O "Link" é obrigatório!']);
    
    $payload = [
        'msg' => $request->input('content'), 
        'title' => $request->input('title'),
        'link' => $request->input('link')
        ];
    
    if (($request->filled('image'))) {
      $payload['img'] = $request->input('image');
    }
    
    $notification = new Helpers\NotificationHelper;
    
    if (!$todos) {
      $this->validate($request, ['para2' => 'required', 'integer'], ['para2.required' => 'Digite o id que receberá a notificação!', 'para2.integer' => 'O id precisa ser um número!', ]);
      $id = $request->input('para2');
      $subscription = Notification::where('id', $id);
      if (!$subscription->exists()) {
        return redirect()->back()->withErrors(['para2' => ['Destinátario não encontrado!']]);
      }
      $to = $subscription->first()->toArray();
      $success = $notification->sendOneNotification($to, $payload);
    }else{
      $to = [];
      $subscriptions = Notification::all();
      foreach ($subscriptions as $subscription){
        $to[] = $subscription->toArray();
      }
      $success = $notification->sendManyNotifications($to, $payload);
    }
    
    if (!$success) {
      return redirect()->back()->withErrors(['para2' => ['Não foi possível enviar a mensagem para 1 ou mais destinatários!']]);
    }else{
      return redirect()->back()->with(['sender' => 'Notificação enviada com sucesso a todos os destinatários!']);
    }
  }
}