<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/{key}/postback', [Controllers\NotificationController::class, 'postback']);

    Route::post('/rastreio', [Controllers\TrackingController::class, 'post'])->name('rastreio.api');

    /*
    APIs reservadas para um possível app

    Route::get('/categoria', [Controllers\ApiController::class, 'listPromosCategorias']);

    Route::get('/loja', [Controllers\ApiController::class, 'listPromosLojas']);

    Route::get('/home', [Controllers\ApiController::class, 'listPromosHome']);

    Route::get('/cupons', [Controllers\ApiController::class, 'listCupons']);*/
});
