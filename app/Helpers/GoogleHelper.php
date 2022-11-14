<?php

namespace App\Helpers;

use App\Models\User;
use Google\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoogleHelper
{
    /**
     * Obtém o usuário do Google
     *
     * @param Request $request
     * @return RedirectResponse|array
     */
    public static function getUser(Request $request): RedirectResponse|array
    {
        if (empty($_COOKIE['g_csrf_token']) || $request->input('g_csrf_token') !== $_COOKIE['g_csrf_token']) {
            return back()->withErrors(['CSRF token inválido']);
        }

        if (!$request->filled('credential')) {
            return back()->withErrors(['Não foi possível entrar com o Google!']);
        }

        $client = new Client([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        ]);

        $user = $client->verifyIdToken($request->input('credential'));

        if (!$user) {
            return back()->withErrors(['Não foi possível entrar com o Google!']);
        }

        $findUser = User::where('google_id', $user['sub'])->first();

        if (empty($findUser) && $user['email_verified']) {
            $findUser = User::where('email', $user['email'])->first();
        }

        return [$findUser, $user];
    }
}
