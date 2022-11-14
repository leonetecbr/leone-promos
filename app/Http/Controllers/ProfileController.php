<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('others');
    }

    /**
     * Mostre o perfil do usuário logado.
     *
     * @param Request $request
     * @return View
     */
    public function my(Request $request): View
    {
        return view('profile', ['user' => $request->user(), 'myProfile' => true]);
    }

    /**
     * Mostra o perfil de outro usuário.
     *
     * @param Request $request
     * @param User $user
     * @return View
     */
    public function others(Request $request, User $user): View
    {
        $isMyProfile = ($request->user()->id === $user->id);

        return view('profile', ['user' => $user, 'myProfile' => $isMyProfile]);
    }


    /**
     * Atualiza a imagem do perfil do usuário
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function newPicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile-picture' => 'required|image|size:3072'
        ]);

        $user = $request->user();

        if (!copy($request->file('profile-picture'), 'img/users/' . $user->id . '.jpg')) {
            return back()->withErrors('Erro ao salvar a imagem');
        }

        if (!$user->image) {
            $user->image = true;
            $user->save();
        }

        return back()->with('success', 'Imagem alterada com sucesso');
    }

    /**
     * Altera o username do usuário
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function editUsername(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|alpha_dash|min:3|max:32|unique:users'
        ]);

        $request->user()->username = $request->input('username');
        $request->user()->save();

        return back()->with('success', 'Nome de usuário alterado com sucesso');
    }
}
