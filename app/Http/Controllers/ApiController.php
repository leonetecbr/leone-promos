<?php
namespace App\Http\Controllers;

use App\Helpers;
use Illuminate\Http\Request;

/**
 * Controla a API de listagem de promoções e cupons
 */
class ApiController extends Controller{

  /**
   * Lista promoções filtrando por loja
   * @param Illuminate\Http\Request $request
   * @return array
   */
  public function listPromosLojas(Request $request): array{
    $page = $request->input('page', 1);
    $id = $request->input('id');
    if (!$id): return []; endif;
    return Helpers\ApiHelper::getPromo(999, $page, $id);
  }

  /**
   * Lista promoções selecionadas por categoria
   * @param Illuminate\Http\Request $request
   * @return array
   */
  public function listPromosCategorias(Request $request): array{
    $page = $request->input('page', 1);
    $id = $request->input('id');
    if (!$id): return []; endif;
    return Helpers\ApiHelper::getPromo($id, $page);
  }
  
  /**
   * Lista promoções da página inicial
   * @param Illuminate\Http\Request $request
   * @return array
   */
  public function listPromosHome(): array{
    return Helpers\ApiHelper::getPromo(9999);
  }

  /**
   * Lista os cupons
   * @param Illuminate\Http\Request $request
   * @return array
   */
  public function listCupons(Request $request): array{
    $page = $request->input('page', 1);
    $loja = $request->input('loja', 0);
    return Helpers\ApiHelper::getCupons($page, $loja);
  }
}