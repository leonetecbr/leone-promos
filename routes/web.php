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
Route::get('/', Controllers\HomeController::class);

Route::get('/categorias', [Controllers\CategoriasController::class, 'get']);
  
Route::get('/categorias/{categoria}/{page?}', [Controllers\CategoriasController::class, 'process'])->where('categoria', '[a-z]+')->where('page', '^[1-9]+[0-9]*$');

Route::get('/lojas', [Controllers\LojasController::class, 'get']);

Route::get('/lojas/{loja}/{page?}', [Controllers\LojasController::class, 'process'])->where('loja', '[a-z]+')->where('page', '^[1-9]+[0-9]*$');

Route::get('/notificacoes', [Controllers\NotificationController::class, 'get']);

Route::post('/register', [Controllers\NotificationController::class, 'register']);

Route::get('/cupons/{page?}', [Controllers\CuponsController::class, 'get'])->where('page', '^[1-9]+[0-9]*$');

Route::get('/privacidade', function (){
    return view('privacidade');
  });

Route::get('/cookies', function (){
    return view('cookies');
  });

Route::match(['get', 'post'], '/search/{query}/{page?}', [Controllers\SearchController::class, 'search'])->where('query', '[\w ]+')->where('page', '^[1-9]+[0-9]*$');

Route::get('/redirect', [Controllers\RedirectController::class, 'process']);

Route::get('/login', [Controllers\UserController::class, 'login'])->name('login');

Route::get('/logout', [Controllers\UserController::class, 'logout'])->middleware('auth');
  
Route::post('/admin', [Controllers\UserController::class, 'auth']);

Route::get('/admin', [Controllers\AdminController::class, 'get'])->middleware('auth')->name('dashboard');

Route::get('/admin/promos', [Controllers\TopPromosController::class, 'list'])->middleware('auth')->name('listpromos');

Route::get('/admin/promos/new', [Controllers\TopPromosController::class, 'new'])->middleware('auth');

Route::get('/admin/promos/edit/{id}', [Controllers\TopPromosController::class, 'edit'])->middleware('auth')->where('id', '[0-9]+');

Route::get('admin/promos/delete/{id}', [Controllers\TopPromosController::class, 'delete'])->middleware('auth')->where('id', '[0-9]+');

Route::post('admin/promos/save', [Controllers\TopPromosController::class, 'save'])->middleware('auth');

Route::get('/403', [
  function (){
    return abort(403);
  }]);