<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/', Controllers\HomeController::class)->name('home');

Route::get('/categorias', [Controllers\CategoriasController::class, 'get'])->name('categorias');

Route::get('/categorias/{categoria}/{page?}', [Controllers\CategoriasController::class, 'process'])->where('categoria', '[a-z]+')->where('page', '^[1-9]+[0-9]*$')->name('categoria');

Route::get('/lojas', [Controllers\LojasController::class, 'get'])->name('lojas');

Route::get('/lojas/{loja}/{page?}', [Controllers\LojasController::class, 'process'])->where('loja', '[a-z]+')->where('page', '^[1-9]+[0-9]*$')->name('loja');

Route::get('/cupons/{page?}', [Controllers\CuponsController::class, 'get'])->where('page', '^[1-9]+[0-9]*$')->name('cupons');

Route::match(['get', 'post'], '/search/{query}/{page?}', [Controllers\SearchController::class, 'search'])->where('query', '[\w ]+')->where('page', '^[1-9]+[0-9]*$');

Route::get('/redirect', [Controllers\RedirectController::class, 'process']);

Route::get('/notificacoes', [Controllers\NotificationController::class, 'get'])->name('notificacoes');

Route::post('/register', [Controllers\NotificationController::class, 'register']);

Route::post('/prefer/get', [Controllers\NotificationController::class, 'getPrefer']);

Route::post('/prefer/set', [Controllers\NotificationController::class, 'setPrefer']);

Route::get('/login', [Controllers\UserController::class, 'login'])->name('login');

Route::get('/logout', [Controllers\UserController::class, 'logout'])->middleware('auth');

Route::post('/admin', [Controllers\UserController::class, 'auth']);

Route::get('/admin', [Controllers\AdminController::class, 'get'])->middleware('auth')->name('dashboard');

Route::get('/admin/promos', [Controllers\TopPromosController::class, 'list'])->middleware('auth')->name('listpromos');

Route::get('/admin/promos/new', [Controllers\TopPromosController::class, 'new'])->middleware('auth');

Route::get('/admin/promos/edit/{id}', [Controllers\TopPromosController::class, 'edit'])->middleware('auth')->where('id', '[0-9]+');

Route::get('/admin/promos/delete/{id}', [Controllers\TopPromosController::class, 'delete'])->middleware('auth')->where('id', '[0-9]+');

Route::post('/admin/promos/save', [Controllers\TopPromosController::class, 'save'])->middleware('auth');

Route::get('/admin/notify', [Controllers\NotificationController::class, 'getAdmin'])->middleware('auth');

Route::post('/admin/notify/send', [Controllers\NotificationController::class, 'send'])->middleware('auth');

Route::get('/403', function () {
  return abort(403);
});

Route::get('/privacidade', function () {
  return view('privacidade');
})->name('privacidade');

Route::get('/cookies', function () {
  return view('cookies');
})->name('cookies');
