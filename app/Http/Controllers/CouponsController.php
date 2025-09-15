<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;

class CouponsController extends Controller
{
    /**
     * Gera a página de cupons
     */
    #[Route('/cupons', name: 'cupons')]
    public static function get(Request $request): View
    {
        $store = $request->input('loja');

        $coupons = Coupon::paginate(12);

        return view('coupons', compact('coupons', 'store'));
    }
}
