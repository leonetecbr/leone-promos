<?php
namespace App\Http\Controllers;

use App\Helpers\ApiHelper;

class HomeController extends Controller{
  public function __invoke(){
    $ofertas = ApiHelper::getPromo(0);
    return view('home', ['top_promos' => $ofertas, 'cat_id' => 0, 'page' => 1]);
  }
}
