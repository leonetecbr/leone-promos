<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;
use App\Models\Promo;
use App\Models\Page;
use App\Models\Notification;

class TopPromosController extends Controller
{

  public function edit(int $id)
  {
    $promo = Promo::where('id', $id)->first();

    if (empty($promo)) {
      return redirect()->route('promos.list')->withErrors([
        'promo' => ['A promoção solicitada não existe!']
      ]);
    } else {
      $promo = $promo->toArray();
      $promo['redirect'] = (strpos($promo['link'], '/redirect?url=') === 0) ? 'checked' : '';
      $title = 'Editar promoção';
    }

    return view('admin.promo', ['title' => $title, 'promo' => $promo, 'id' => $id]);
  }

  public function new()
  {
    return view('admin.promo', ['title' => 'Nova promoção']);
  }

  public function delete($id)
  {
    $promo = Promo::where('id', $id)->first();

    if (empty($promo)) {
      return redirect()->route('promos.list')->withErrors([
        'promo' => ['A promoção solicitada não existe!']
      ]);
    }

    $promo->delete();

    return redirect()->route('promos.list');
  }

  public function list()
  {
    $promos = Helpers\ApiHelper::getPromo(9999);
    for ($i = 0; $i < count($promos['offers']); $i++) {
      $promos['offers'][$i]['link'] = '/admin/promos/edit/' .  $promos['offers'][$i]['id'];
      $promos['offers'][$i]['store']['link'] = '/admin/promos/edit/' . $promos['offers'][$i]['id'];
    }

    $botao = '<a href="'.route('promos.new').'"><button type="submit" class="btn btn-primary text-light mb-4 mt-2 btn-lg w-75">Nova promoção</button></a>';

    return view('promos', ['title' => 'Top Promos', 'subtitle' => 'Top Promos', 'promos' => $promos['offers'], 'cat_id' => 0, 'page' => 1, 'topo' => $topo ?? true, 'share' => false, 'add' => $botao]);
  }

  public function save(Request $request)
  {
    $dados = $this->validate($request, [
      'name' => 'required', 
      'link' => 'required', 
      'thumbnail' => 'required', 
      'price' => 'required', 
      'store_id' => 'required'
    ]);

    $pages = Page::where('id', 9999)->first();

    if (empty($pages)) {
      $pages = new Page();
      $pages->id = 9999;
      $pages->total = 1;
      $pages->save();
    }

    if ($request->filled('id')) {
      $p = Promo::where('id', $request->input('id'))->first();
      if (empty($p)) {
        $p = new Promo();
        $p->id = 9 . date('dHis');
      }
    } else {
      $p = new Promo();
      $p->id = 9 . date('dHis');
    }

    $p->nome = mb_strimwidth($dados['name'], 0, 50, '...', 'UTF-8');
    $p->group_id = 9999;
    $p->store_id = $dados['store_id'];
    $p->link = ($request->filled('redirect') && !$request->filled('id')) ? '/redirect?url=' . $dados['link'] : $dados['link'];
    $p->por = $dados['price'];
    $p->imagem = $dados['thumbnail'];
    $p->de = $request->input('priceFrom');
    $p->code = $request->input('code');
    $p->desc = $request->input('description');
    $p->parcelas =  $request->input('installment_value');
    $p->vezes = $request->input('installment_quantity');

    if ($p->save()) {
      if ($request->filled('notify')){
        $payload = [
          'title' => $p->nome,
          'link' => '/#promo-0-1-' . substr($p->id, -2)
        ];

        if($p->por <= 0){
          $payload['msg'] = 'Grátis!';
        }elseif ($p->de) {
          $payload['msg'] = 'De: R$'. number_format($p->de, 2, ',', '.') . "\nPor apenas R$". number_format($p->por, 2, ',', '.') .'!';
        }else{
          $payload['msg'] = 'Por apenas R$' . number_format($p->por, 2, ',', '.') . '!';
          $payload['msg'] .= ($p->desc) ? "\n".mb_strimwidth($p->desc, 0, 50, '...', 'UTF-8') : '';
        }

        if($p->imagem){
          $payload['img'] = $p->imagem;
        }

        $success = $this->sendNotification($request, $payload);
      } else{
        $success = true;
      }
      if ($success){
        return redirect()->route('promos.list');
      } else{
        return redirect()->route('promos.list')->withErrors([
          'notify' => ['Erro ao enviar a notificação para um ou mais destinatários!']
        ]);
      }
    } else {
      return redirect()->route('promos.list')->withErrors([
        'store_id' => ['Erro ao salvar, provável erro no store_id!']
      ]);
    }
  }

  private function sendNotification(Request $request, array $payload): bool{
    $todos = $request->input('para', false);

    $notification = new Helpers\NotificationHelper;

    if (!$todos) {
      if ($request->filled('p1')) {
        $where = 'p1 = 1';
      }
      if ($request->filled('p2')) {
        if (empty($where)) {
          $where = 'p2 = 1';
        } else {
          $where .= ' or p2 = 1';
         }
       }
      if ($request->filled('p3')) {
        if (empty($where)) {
          $where = 'p3 = 1';
        } else {
          $where .= ' or p3 = 1';
        }
      }
      if ($request->filled('p4')) {
        if (empty($where)) {
          $where = 'p4 = 1';
        } else {
          $where .= ' or p4 = 1';
        }
      }
      if ($request->filled('p5')) {
        if (empty($where)) {
          $where = 'p5 = 1';
        } else {
          $where .= ' or p5 = 1';
        }
      }
      if ($request->filled('p6')) {
        if (empty($where)) {
          $where = 'p6 = 1';
        } else {
          $where .= ' or p6 = 1';
        }
      }
      if ($request->filled('p7')) {
        if (empty($where)) {
          $where = 'p7 = 1';
        } else {
          $where .= ' or p7 = 1';
        }
      }
      if ($request->filled('p8')) {
        if (empty($where)) {
          $where = 'p8 = 1';
        } else {
          $where .= ' or p8 = 1';
        }
      }
      if ($request->filled('p9')) {
        if (empty($where)) {
          $where = 'p9 = 1';
        } else {
          $where .= ' or p9 = 1';
        }
      }
      if (empty($where)) {
        return false;
      } else {
        $subscriptions = Notification::whereRaw($where)->get();
        foreach ($subscriptions as $subscription) {
          $to[] = $subscription->toArray();
        }
        $success = $notification->sendManyNotifications($to, $payload);
      }
    } else {
      $to = [];
      $subscriptions = Notification::all();
      foreach ($subscriptions as $subscription) {
        $to[] = $subscription->toArray();
      }
      $success = $notification->sendManyNotifications($to, $payload);
    }

    return $success;
  }
}
