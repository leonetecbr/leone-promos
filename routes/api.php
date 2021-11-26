<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/v1/{key}/postback', [Controllers\NotificationController::class, 'postback']);

/*
APIs reservadas para um possível app

Route::get('/v1/categoria', [Controllers\ApiController::class, 'listPromosCategorias']);

Route::get('/v1/loja', [Controllers\ApiController::class, 'listPromosLojas']);

Route::get('/v1/home', [Controllers\ApiController::class, 'listPromosHome']);

Route::get('/v1/cupons', [Controllers\ApiController::class, 'listCupons']);*/