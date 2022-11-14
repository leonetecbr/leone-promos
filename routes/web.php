<?php

use App\Http\Controllers;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Controllers\HomeController::class, 'get'])->name('home');

Route::controller(Controllers\LoginController::class)->group(function () {

    Route::prefix('login')->name('login')->group(function () {
        Route::get('/', 'get');
        Route::post('/google', 'google')->name('.google')->withoutMiddleware(VerifyCsrfToken::class);
    });

    Route::get('/logout', [Controllers\LoginController::class, 'logout'])->name('logout');
});

Route::controller(Controllers\ProfileController::class)->prefix('perfil')->name('profile')
    ->group(function () {

        Route::get('/', 'my');
        Route::get('/{user:username}', 'others')->name('.others');
        Route::post('/nova-foto', 'newPicture')->name('.newPicture');
        Route::post('/editar-username', 'editUsername')->name('.editUsername');
    });

Route::controller(Controllers\SettingsController::class)->name('settings')->prefix('configuracoes')
    ->group(function () {

        Route::get('/', 'get');
        Route::post('/alterar-email', 'changeMail')->name('.changeMail');
        Route::post('/alterar-senha', 'changePass')->name('.changePass');
        Route::post('/deletar-conta', 'deleteAccount')->name('.deleteAccount');
    });

Route::get('/cadastrar', [Controllers\RegisterController::class, 'get'])->name('register');

Route::view('/privacidade', 'privacy')->name('privacidade');

Route::view('/cookies', 'cookies')->name('cookies');

Route::view('/cupons', 'cookies')->name('coupons');
Route::view('/lojas', 'cookies')->name('stores');
Route::view('/categorias', 'cookies')->name('categories');
Route::view('/notificacoes', 'cookies')->name('notifications');
Route::view('/rastreio', 'cookies')->name('tracking');
Route::view('/painel', 'cookies')->name('dashboard');
