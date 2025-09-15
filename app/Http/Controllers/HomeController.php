<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Contracts\View\View;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{

    /**
     * Gera a página inicial
     */
    #[Route('/', name: 'home')]
    public function __invoke(): View
    {
        $promotions = Promotion::where('is_top', 1)->with('store:id,name,image,link')->orderByDesc('created_at')->paginate(12);

        return view('home', compact('promotions'));
    }
}
