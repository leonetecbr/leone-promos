<?php

namespace App\Http\Controllers;

use App\Helpers;

class CuponsController extends Controller
{
  public static function get($page = 1)
  {
    $cupons = Helpers\ApiHelper::getCupons($page);
    $final = $cupons['totalPage'];
    $cupons = $cupons['coupons'];
    return view('cupons', [
      'cupons' => $cupons,
      'group_name' => 1,
      'final' => $final,
      'page' => $page
    ]);
  }
}
