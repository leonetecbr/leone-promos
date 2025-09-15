<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * Gera a página inicial do painel administrativo
     */
    #[Route('/admin', name: 'dashboard')]
    public function get(): View
    {
        return view('admin.home');
    }
}
