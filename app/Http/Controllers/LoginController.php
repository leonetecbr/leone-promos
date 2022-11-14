<?php

namespace App\Http\Controllers;

use App\Helpers\GoogleHelper;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
        $this->middleware('guest')->except('logout');
    }

    /**
     * Gera a página de login
     *
     * @return View
     */
    public function get(): View
    {
        return view('login');
    }

    /**
     * Faz o login com o Google
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function google(Request $request): RedirectResponse
    {
        [$user, $google] = GoogleHelper::getUser($request);

        if (empty($user)) {
            $user = new User();
            $user->email = $google['email'];

            if ($google['email_verified']) {
                $user->email_verified_at = now();
            }

            $google['username'] = mb_strimwidth(str_replace(' ', '', $google['name']), 0, 26);

            $user->image = !empty($google['picture']);
            $user->google_id = $google['sub'];
            $user->username = $google['username'] . rand(100000, 999999);
            $user->save();

            if (!empty($google['picture'])) {
                copy($google['picture'], public_path("img/users/$user->id.jpg"));
            }
        }

        Auth::login($user);

        return to_route('home');
    }

    /**
     * Faz logout do usuário
     *
     * @return RedirectResponse
     */
    function logout(): RedirectResponse
    {
        Auth::logout();
        return to_route('login');
    }
}
