<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  /**
   * Gera a página inicial do painel administrativo
   */
  public function get()
  {
    return view('admin.home');
  }
}
