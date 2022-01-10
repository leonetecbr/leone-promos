<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;

class HomeController extends Controller
{
  public function __invoke()
  {
    $ofertas = ApiHelper::getPromo(9999);
    return view('home', ['promos' => $ofertas['offers'], 'cat_id' => 0, 'page' => 1]);
  }
}
