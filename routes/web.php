<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;

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

Route::prefix('login')
    ->name('login')
    ->controller(Controllers\LoginController::class)->group(function () {

        Route::get('/', 'get')->middleware('guest');
        Route::post('/google', 'google')->name('.google')->withoutMiddleware(VerifyCsrfToken::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/logout', [Controllers\LoginController::class, 'logout'])->name('logout');

    Route::prefix('perfil')
        ->name('profile')
        ->controller(Controllers\ProfileController::class)->group(function () {

            Route::get('/', 'my');
            Route::get('/{user:username}', 'others')->name('.others')->withoutMiddleware('auth');
            Route::post('/nova-foto', 'newPicture')->name('.newPicture');
            Route::post('/editar-username', 'editUsername')->name('.editUsername');
        });
});

Route::get('/configuracoes', [Controllers\SettingsController::class, 'get'])->name('settings');


Route::get('/cadastrar', [Controllers\RegisterController::class, 'get'])->name('register')
    ->middleware('guest');

Route::view('/privacidade', 'privacy')->name('privacidade');

Route::view('/cookies', 'cookies')->name('cookies');

Route::view('/cupons', 'cookies')->name('coupons');
Route::view('/lojas', 'cookies')->name('stores');
Route::view('/categorias', 'cookies')->name('categories');
Route::view('/notificacoes', 'cookies')->name('notifications');
Route::view('/rastreio', 'cookies')->name('tracking');
Route::view('/painel', 'cookies')->name('dashboard');
