<?php

namespace App\Http\Controllers;

use App\Helpers;
use Illuminate\Http\Request;

class CuponsController extends Controller
{
  public static function get(Request $request, $page = 1)
  {
    $loja = $request->input('loja');
    switch ($loja) {
      case 'Americanas':
        $store_id = 5632;
        break;

      case 'CasasBahia':
        $store_id = 2;
        break;

      case 'Consul':
        $store_id = 5937;
        break;

      case 'Ponto':
        $store_id = 4;
        break;

      case 'Submarino':
        $store_id = 5766;
        break;

      case 'Efacil':
        $store_id = 5779;
        break;

      case 'Positivo':
        $store_id = 6117;
        break;

      case 'Lenovo':
        $store_id = 5798;
        break;

      default:
        $store_id = 0;
    }
    $cupons = Helpers\ApiHelper::getCupons($page, $store_id);
    $final = $cupons['totalPage'] ?? 1;
    $cupons = $cupons['coupons'] ?? [];
    return view('cupons', [
      'cupons' => $cupons,
      'group_name' => 1,
      'final' => $final,
      'page' => $page,
      'loja' => $loja
    ]);
  }
}
