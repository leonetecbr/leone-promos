<?php

namespace App\Http\Controllers;

use App\Helpers;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/api/v1/loja')]
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
    #[Route('/api/v1/categoria')]
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
    #[Route('/api/v1/home')]
    public function listPromosHome(): array
    {
        return Helpers\ApiHelper::getPromo(9999);
    }

    /**
     * Lista os cupons
     * @param Request $request
     * @return array
     * @throws Exception
     */
    #[Route('/api/v1/cupons')]
    public function listCupons(Request $request): array
    {
        $page = $request->input('page', 1);
        $loja = $request->input('loja', 0);
        return Helpers\ApiHelper::getCoupons($page, $loja);
    }
}
