<?php
namespace App\Http\Controllers;

use App\Helpers;

class CuponsController extends Controller{
  public static function get($page = 1){
    $cupons = Helpers\ApiHelper::getCupons();
    $final = ceil(count($cupons)/18);
    return view('cupons', [
      'cupons' => $cupons,
      'pages' => Helpers\PromosHelper::getPages($page, $final),
      'page' => $page
    ]);
  }
}
