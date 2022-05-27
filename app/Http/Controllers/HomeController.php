<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    /**
     * Gera a página inicial
     * @returns View
     */
    public function __invoke(): View
    {
        $ofertas = ApiHelper::getPromo(9999);
        return view('home', ['promos' => $ofertas['offers'], 'cat_id' => 0, 'page' => 1]);
    }
}
