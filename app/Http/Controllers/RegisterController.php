<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Mostra a página de cadastro.
     *
     * @return View
     */
    public function get(): View
    {
        return view('register');
    }
}
