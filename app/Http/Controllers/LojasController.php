<?php
namespace App\Http\Controllers;

use App\Helpers;
use Exception;

class LojasController extends Controller{
    
  /*
   *
   */
  public static function get(){
    return view('lojas');
  }
  
  /*
   *
   */
  public static function process(string $loja, int $page = 1){
    try{
      switch ($loja) {
        case 'magalu':
          $redirect = new Response(303);
          $redirect->addHeader('Location', 'https://www.magazinevoce.com.br/magazineofertasleone/');
          $redirect->sendResponse();
        
        case 'americanas':
          $store = 5632;
          $title = 'Americanas';
          break;
        
        case 'girafa':
          $store = 5727;
          $title = 'Girafa';
          break;
        
        case 'submarino':
          $store = 5766;
          $title = 'Submarino';
          break;
        
        case 'shoptime':
          $store = 5644;
          $title = 'Shoptime';
          break;
        
        case 'brandili':
          $store = 7863;
          $title = 'Brandili';
          break;
        
        case 'usaflex':
          $store = 6358;
          $title = 'Usaflex';
          break;
        
        case 'electrolux':
          $store = 6078;
          $title = 'Electrolux';
          break;
        
        case 'itatiaia':
          $store = 7460;
          $title = 'Itatiaia';
          break;
        
        case 'brastemp':
          $store = 5936;
          $title = 'Brastemp';
          break;
        
        case 'positivo':
          $store = 6117;
          $title = 'Positivo';
          break;
        
        case 'etna':
          $store = 6373;
          $title = 'Etna';
          break;
        
        case 'repassa':
          $store = 6104;
          $title = 'Repassa';
          break;
        
        default:
          throw new Exception('Loja não encontrada!');
          break;
      }
      $dado = Helpers\ApiHelper::getPromo(999, $page, $store);
      $ofertas = $dado['offers'];
      $pages = $dado['pagination']['totalPage'];
      $pagination = Helpers\PromosHelper::getPages($page, $pages);
    }catch (Exception $e){
      $title = 'Não encontrada';
      $ofertas = '<p class="fs-12 erro">'.$e->getMessage().'</p>';
      $topo = false;
    }
    
    return view('promos', ['title' => 'Loja: '.$title, 'subtitle' => $title, 'promos' => $ofertas, 'cat_id' => $store??0, 'page' => $page, 'pages' => $pagination??'', 'topo' => $topo??true]);
  }
}
