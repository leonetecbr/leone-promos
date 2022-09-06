<?php

namespace App\Http\Controllers;

use App\Helpers;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{

    /**
     * Gera a página de Login
     * @returns View|RedirectResponse
     */
    #[Route('/login', name: 'login')]
    public function login(): View|RedirectResponse
    {
        if (Auth::check()) {
            return to_route('dashboard');
        } else {
            return view('login');
        }
    }

    /**
     * Realiza a autenticação do usuário
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    #[Route('/admin')]
    public function auth(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $recaptchaResponse = $request->input('g-recaptcha-response');

        $robot = new Helpers\RecaptchaHelper($request, $recaptchaResponse, 'v2');

        $isRobot = $robot->isOrNot();

        if ($isRobot) {
            return redirect()->back()->withErrors([
                'g-recaptcha' => ['Talvez você seja um robô!']
            ])->withInput();
        }

        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            return to_route('dashboard');
        } else {
            return redirect()->back()->withErrors([
                'password' => ['E-mail e/ou senha inválidos!']
            ])->withInput();
        }
    }

    /**
     * Realiza o logout
     * @returns RedirectResponse
     */
    #[Route('/logout', name: 'logout')]
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return to_route('login');
    }
}
