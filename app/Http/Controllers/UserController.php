<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers;

class UserController extends Controller{
  public function login(){
    return view('login');
  }
  
  public function auth(Request $request){
    $this->validate($request, ['email' => ['required', 'email'], 'password' => ['required'], 'g-recaptcha-response' => ['required']], ['email.required' => 'E-mail é obrigatório!','email.email' => 'Digite um e-mail válido!','password.required' => 'Senha é obrigatória!', 'g-recaptcha-response.required' => 'Marque a caixa "Não sou um robô"!']);
    
    $email = $request->input('email');
    $password = $request->input('password');
    $g_response = $request->input('g-recaptcha-response');
    
    $robot = new Helpers\RecaptchaHelper($request, $g_response, 'v2');
      
    $isRobot = $robot->isOrNot();
    
    if($isRobot){
      return redirect()->back()->withErrors([
            'g-recaptcha' => ['Talvez você seja um robô!']])->with('email', $email);
    }
    
    if (Auth::attempt(['email' => $email, 'password' => $password], false)){
      return redirect()->route('dashboard');
    }else{
      return redirect()->back()->withErrors([
            'password' => ['E-mail e/ou senha inválidos!']
        ])->with('email', $email);
    }
  }
  
  public function logout(){
     Auth::logout();
     return redirect()->route('login');
  }
}
