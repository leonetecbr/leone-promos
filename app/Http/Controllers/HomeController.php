<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Exception;
use Illuminate\Contracts\View\View;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{

    /**
     * Gera a página inicial
     * @returns View
     * @throws Exception
     */
    #[Route('/', name: 'home')]
    public function __invoke(): View
    {
        $offers = ApiHelper::getPromo(9999);
        return view('home', ['promos' => $offers['offers'], 'catId' => 0, 'page' => 1]);
    }
}
