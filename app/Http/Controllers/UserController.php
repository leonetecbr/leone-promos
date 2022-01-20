<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers;

class UserController extends Controller
{

  /**
   * Gera a página de Login
   */
  public function login()
  {
    if (Auth::check()) {
      return redirect()->route('dashboard');
    } else {
      return view('login');
    }
  }

  /**
   * Realiza a autenticação do usuário
   *
   * @param Request $request
   */
  public function auth(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email', 
      'password' => 'required',
      'g-recaptcha-response' => 'required'
    ]);

    $email = $request->input('email');
    $password = $request->input('password');
    $g_response = $request->input('g-recaptcha-response');

    $robot = new Helpers\RecaptchaHelper($request, $g_response, 'v2');

    $isRobot = $robot->isOrNot();

    if ($isRobot) {
      return redirect()->back()->withErrors([
        'g-recaptcha' => ['Talvez você seja um robô!']
      ])->with('email', $email);
    }

    if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
      return redirect()->route('dashboard');
    } else {
      return redirect()->back()->withErrors([
        'password' => ['E-mail e/ou senha inválidos!']
      ])->with('email', $email);
    }
  }

  /**
   * Realiza o logout
   */
  public function logout()
  {
    Auth::logout();
    return redirect()->route('login');
  }
}
