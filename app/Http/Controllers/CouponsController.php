<?php

namespace App\Http\Controllers;

use App\Helpers;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;

class CouponsController extends Controller
{

    const TOP_STORES = [
        'Americanas' => 5632,
        'Casas Bahia' => 2,
        'Consul' => 5937,
        'Ponto' => 4,
        'Submarino' => 5766,
        'Efácil' => 5779,
        'Positivo' => 6117,
        'Lenovo' => 5798
    ];

    /**
     * Gera a página de cupons
     *
     * @param Request $request
     * @param int $page
     * @return View
     * @throws Exception
     * @paramint $page
     */
    #[Route('/cupons/{page?}', name: 'cupons')]
    public static function get(Request $request, int $page = 1): View
    {
        $store = $request->input('loja');

        $storeId = ($store == '') ?
            0 :
            (self::TOP_STORES[$store] ?? null);

        $coupons = (!is_null($storeId)) ?
            Helpers\ApiHelper::getCoupons($page, $storeId) :
            'A loja informada é inválida!';

        $endPage = $coupons['totalPage'] ?? 1;
        $coupons = $coupons['coupons'] ?? [];

        return view('coupons', [
            'coupons' => $coupons,
            'groupName' => 1,
            'endPage' => $endPage,
            'page' => $page,
            'store' => $store,
            'topStores' => self::TOP_STORES
        ]);
    }
}
