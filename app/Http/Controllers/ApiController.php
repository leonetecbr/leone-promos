<?php

namespace App\Http\Controllers;

use App\Helpers;
use Exception;
use Illuminate\Http\Request;

/**
 * Controla a API de listagem de promoções e cupons
 */
class ApiController extends Controller
{

    /**
     * Lista as promoções filtrando por loja
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function listPromosLojas(Request $request): array
    {
        $page = $request->input('page', 1);
        $id = $request->input('id');
        if (!$id) : return [];
        endif;
        return Helpers\ApiHelper::getPromo(999, $page, $id);
    }

    /**
     * Lista as promoções selecionadas por categoria
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function listPromosCategorias(Request $request): array
    {
        $page = $request->input('page', 1);
        $id = $request->input('id');
        if (!$id) : return [];
        endif;
        return Helpers\ApiHelper::getPromo($id, $page);
    }

    /**
     * Lista as promoções da página inicial
     * @return array
     * @throws Exception
     */
    public function listPromosHome(): array
    {
        return Helpers\ApiHelper::getPromo(9999);
    }

    /**
     * Lista os cupons
     * @param Request $request
     * @return array
     */
    public function listCupons(Request $request): array
    {
        $page = $request->input('page', 1);
        $loja = $request->input('loja', 0);
        return Helpers\ApiHelper::getCupons($page, $loja);
    }
}
