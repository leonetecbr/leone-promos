<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingsController extends Controller
{

    /**
     * Mostra a página de configurações
     *
     * @param Request $request
     * @return View
     */
    public function get(Request $request): View
    {
        return view('settings', ['user' => $request->user(),]);
    }

    /**
     * Atualiza o email do usuário
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeMail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);

        $request->user()->email = $request->input('email');
        $request->user()->email_verified_at = NULL;
        $request->user()->save();

        // TODO: Enviar email de confirmação

        return back()->with('success', 'Email alterado com sucesso');
    }

    /**
     * Atualiza a senha do usuário
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function changePass(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!is_null($user->password)) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|min:8|max:32'
            ]);
        } else {
            $request->validate([
                'password' => 'required|min:8|max:32'
            ]);
        }

        $user->password = Hash::make($request->input('password'));
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));

        return back()->with('success', 'Senha alterada com sucesso');
    }

    /**
     * Deleta a conta do usuário
     *
     * @param Request $request
     * @return View
     */
    public function deleteAccount(Request $request): View
    {
        // TODO: Implementar
    }
}
