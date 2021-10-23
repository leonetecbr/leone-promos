<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;

class TopPromosController extends Controller
{
  private static $arquivo = __DIR__ . '/../../../resources/cache/0_1.json';

  public function edit(int $id)
  {
    $promos = json_decode(file_get_contents(self::$arquivo), true);

    if (empty($promos[$id])) {
      return redirect()->route('listpromos')->withErrors([
        'promo' => ['A promoção solicitada não existe!']
      ]);
    } else {
      $promo = $promos[$id];
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
    $promos = json_decode(file_get_contents(self::$arquivo), true);

    if (empty($promos[$id])) {
      return redirect()->route('listpromos')->withErrors([
        'promo' => ['A promoção solicitada não existe!']
      ]);
    }

    unset($promos[$id]);
    $promos = array_values($promos);

    file_put_contents(self::$arquivo, json_encode($promos));

    return redirect()->route('listpromos');
  }

  public function list()
  {
    $promos = json_decode(file_get_contents(self::$arquivo), true);

    for ($i = 0; $i < count($promos); $i++) {
      $promos[$i]['link'] = '/admin/promos/edit/' . $i;
      $promos[$i]['store']['link'] = '/admin/promos/edit/' . $i;
    }

    $botao = '<a href="/admin/promos/new"><button type="submit" class="padding mb-2 btn-static bg-orange flex-center radius">Nova promoção</button></a>';

    return view('promos', ['title' => 'Top Promos', 'subtitle' => 'Top Promos', 'promos' => $promos, 'cat_id' => 0, 'page' => 1, 'topo' => $topo ?? true, 'share' => false, 'add' => $botao]);
  }

  public function save(Request $request)
  {
    $this->validate($request, ['name' => 'required', 'link' => 'required', 'thumbnail' => 'required', 'price' => 'required', 'store_name' => 'required', 'store_link' => 'required', 'store_thumbnail' => 'required'], ['name.required' => 'O "Título" é obrigatório!', 'link.required' => 'O "Link" é obrigatório!', 'thumbnail.required' => 'A "Imagem" é obrigatória!', 'price.required' => 'O "Por" é obrigatório!', 'store_name.required' => 'O "Nome da Loja" é obrigatório!', 'store_link.required' => 'O "Link da Loja" é obrigatório!', 'store_thumbnail.required' => 'A "Imagem da Loja" é obrigatória!']);


    $dados = $request->only('name', 'link', 'thumbnail', 'price');

    $dados['store'] = [
      'name' => $request->input('store_name'),
      'thumbnail' => $request->input('store_thumbnail'),
      'link' => $request->input('store_link')
    ];

    if ($request->filled('priceFrom')) {
      if (!$request->filled('discount')) {
        $dados['discount'] = $request->input('priceFrom') - $request->input('price');
      } else {
        $dados['discount'] = $request->input('discount');
      }
      $dados['priceFrom'] = $request->input('priceFrom');
    }

    if ($request->filled('code')) {
      $dados['code'] = $request->input('code');
    }

    if ($request->filled('description')) {
      $dados['description'] = $request->input('description');
    }

    if ($request->filled('installment_quantity') && $request->filled('installment_value')) {
      $dados['installment'] = [
        'value' => $request->input('installment_value'),
        'quantity' => $request->input('installment_quantity')
      ];
    }

    $promos = json_decode(file_get_contents(self::$arquivo), true);
    if ($request->filled('id')) {
      $promos[$request->input('id')] = $dados;
    } else {
      $promos[] = $dados;
    }

    file_put_contents(self::$arquivo, json_encode($promos));

    return redirect()->route('listpromos');
  }
}
