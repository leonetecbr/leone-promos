<?php

namespace App\Http\Controllers;

use App\Helpers;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CuponsController extends Controller
{

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
        switch ($store) {
            case 'Americanas':
                $storeId = 5632;
                break;

            case 'Casas Bahia':
                $storeId = 2;
                break;

            case 'Consul':
                $storeId = 5937;
                break;

            case 'Ponto':
                $storeId = 4;
                break;

            case 'Submarino':
                $storeId = 5766;
                break;

            case 'Efácil':
                $storeId = 5779;
                break;

            case 'Positivo':
                $storeId = 6117;
                break;

            case 'Lenovo':
                $storeId = 5798;
                break;

            default:
                $storeId = 0;
        }
        $coupons = Helpers\ApiHelper::getCoupons($page, $storeId);
        $endPage = $coupons['totalPage'] ?? 1;
        $coupons = $coupons['coupons'] ?? [];
        return view('cupons', [
            'coupons' => $coupons,
            'groupName' => 1,
            'endPage' => $endPage,
            'page' => $page,
            'store' => $store
        ]);
    }
}
