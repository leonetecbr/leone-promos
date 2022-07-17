<?php

namespace App\Http\Controllers;

use App\Helpers;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
     * @param integer $page
     * @return View
     * @throws Exception
     */
    public static function get(Request $request, int $page = 1): View
    {
        $store = $request->input('loja');

        if ($store == '') {
            $storeId = 0;
        } elseif (!empty(self::TOP_STORES[$store])) {
            $storeId = self::TOP_STORES[$store];
        } else {
            $storeId = null;
            $coupons = 'A loja informada é inválida!';
            $endPage = 1;
        }

        if (!is_null($storeId)) {
            $coupons = Helpers\ApiHelper::getCoupons($page, $storeId);
            $endPage = $coupons['totalPage'] ?? 1;
            $coupons = $coupons['coupons'] ?? [];
        }

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
