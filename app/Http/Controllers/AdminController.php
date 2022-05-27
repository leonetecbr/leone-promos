<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    /**
     * Gera a página inicial do painel administrativo
     * @returns View
     */
    public function get(): View
    {
        return view('admin.home');
    }
}
