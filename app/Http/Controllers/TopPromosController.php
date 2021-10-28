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
      return redirect()->route('listpromos')->withErrors([
        'promo' => ['A promoção solicitada não existe!']
      ]);
    } else {
      $promo = $promo->toArray();
      $title = 'Editar promoção';
    }

    return view('admin.promos', ['title' => $title, 'promo' => $promo, 'id' => $id]);
  }

  public function new()
  {
    return view('admin.promos', ['title' => 'Nova promoção']);
  }

  public function delete($id)
  {
    $promo = Promo::where('id', $id)->first();

    if (empty($promo)) {
      return redirect()->route('listpromos')->withErrors([
        'promo' => ['A promoção solicitada não existe!']
      ]);
    }

    $promo->delete();

    return redirect()->route('listpromos');
  }

  public function list()
  {
    $promos = Helpers\ApiHelper::getPromo(9999);
    for ($i = 0; $i < count($promos['offers']); $i++) {
      $promos['offers'][$i]['link'] = '/admin/promos/edit/' .  $promos['offers'][$i]['id'];
      $promos['offers'][$i]['store']['link'] = '/admin/promos/edit/' . $promos['offers'][$i]['id'];
    }

    $botao = '<a href="/admin/promos/new"><button type="submit" class="padding btn-static bg-orange flex-center radius">Nova promoção</button></a>';

    return view('promos', ['title' => 'Top Promos', 'subtitle' => 'Top Promos', 'promos' => $promos['offers'], 'cat_id' => 0, 'page' => 1, 'topo' => $topo ?? true, 'share' => false, 'add' => $botao]);
  }

  public function save(Request $request)
  {
    $this->validate($request, ['name' => 'required', 'link' => 'required', 'thumbnail' => 'required', 'price' => 'required', 'store_id' => 'required'], ['name.required' => 'O "Título" é obrigatório!', 'link.required' => 'O "Link" é obrigatório!', 'thumbnail.required' => 'A "Imagem" é obrigatória!', 'price.required' => 'O "Por" é obrigatório!', 'store_id.required' => 'O "Id da Loja" é obrigatório!']);

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

    $p->nome = mb_strimwidth($request->input('name'), 0, 50, '...');
    $p->group_id = 9999;
    $p->store_id = $request->input('store_id');
    $p->link = $request->input('link');
    $p->por = $request->input('price');
    $p->imagem = $request->input('thumbnail');
    $p->de = $request->input('priceFrom');
    $p->code = $request->input('code');
    $p->desc = $request->input('description');
    $p->parcelas =  $request->input('installment_value');
    $p->vezes = $request->input('installment_quantity');

    if ($p->save()) {
      return redirect()->route('listpromos');
    } else {
      return redirect()->route('listpromos')->withErrors([
        'store_id' => ['Erro ao salvar, provável erro no store_id!']
      ]);
    }
  }
}
