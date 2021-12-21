<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;
use App\Models\Promo;
use App\Models\Page;

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

    $p->nome = mb_strimwidth($dados['name'], 0, 50, '...');
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
      return redirect()->route('promos.list');
    } else {
      return redirect()->route('promos.list')->withErrors([
        'store_id' => ['Erro ao salvar, provável erro no store_id!']
      ]);
    }
  }
}
