<?php

use App\Http\Controllers;
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

/* BEGIN Suspensão do funcionamento do site
if (env('SITE_OFF', false)) {
    Route::any('/{uri?}', function ($uri = '') {
        return view('suspend');
    })->name('home');
}
END Suspensão do funcionamento do site*/

Route::domain(env('APP_DOMAIN'))->group(function () {

    Route::get('/', Controllers\HomeController::class)->name('home');

    Route::controller(Controllers\CategoriesController::class)->prefix('categorias')->group(function () {
        Route::get('/', 'get')->name('categorias');

        Route::get('/{categoria}/{page?}', 'process')->whereAlpha('categoria')->where('page', '^[1-9]+[0-9]*$')->name('categoria');
    });

    Route::controller(Controllers\StoresController::class)->prefix('lojas')->group(function () {
        Route::get('/', 'get')->name('lojas');

        Route::get('/{loja}/{page?}', 'process')->whereAlpha('loja')->where('page', '^[1-9]+[0-9]*$')->name('loja');
    });

    Route::get('/cupons/{page?}', [Controllers\CouponsController::class, 'get'])->where('page', '^[1-9]+[0-9]*$')->name('cupons');

    Route::match(['get', 'post'], '/search/{query}/{page?}', [Controllers\SearchController::class, 'search'])->where(['query' => '[\w ]+', 'page' => '^[1-9]+[0-9]*$'])->name('pesquisa');

    Route::controller(Controllers\RedirectController::class)->prefix('redirect')->group(function () {
        Route::get('/', 'get')->name('redirect.page');

        Route::post('/', 'api')->name('redirect.api');
    });

    Route::controller(Controllers\NotificationController::class)->group(function () {
        Route::prefix('notificacoes')->group(function () {
            Route::get('/', 'get')->name('notificacoes');

            Route::post('/manage', 'userManage');
        });

        Route::prefix('prefer')->group(function () {
            Route::post('/get', 'getPrefer');

            Route::post('/set', 'setPrefer')->name('prefer.set');
        });
    });

    Route::get('/rastreio', [Controllers\TrackingController::class, 'get'])->name('rastreio');
    Route::get('/login', [Controllers\UserController::class, 'login'])->name('login');

    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [Controllers\UserController::class, 'logout'])->name('logout');

        Route::prefix('admin')->group(function () {
            Route::post('/', [Controllers\UserController::class, 'auth'])->withoutMiddleware('auth');

            Route::get('/', [Controllers\AdminController::class, 'get'])->name('dashboard');

            Route::controller(Controllers\TopPromosController::class)->prefix('promos')->group(function () {
                Route::get('/', 'list')->name('promos.list');

                Route::get('/new', 'new')->name('promos.new');

                Route::get('/edit/{id}', 'edit')->whereNumber('id');

                Route::get('/delete/{id}', 'delete')->whereNumber('id')->name('promos.delete');

                Route::post('/save', 'save')->name('promos.save');
            });

            Route::prefix('notification')->group(function () {
                Route::get('/', [Controllers\NotificationController::class, 'getAdmin'])->name('notification.new');

                Route::post('/send', [Controllers\NotificationController::class, 'send'])->name('notification.send');

                Route::get('/history/{page?}', [Controllers\SendedNotificationController::class, 'get'])->name('notification.history');
            });

            Route::controller(controllers\StoresController::class)->prefix('lojas')->group(function () {
                Route::get('/new', 'new')->name('lojas.new');

                Route::post('/save', 'save')->name('lojas.save');
            });
        });
    });

    Route::get('/403', function () {
        return abort(403);
    });

    Route::view('/privacidade', 'privacy')->name('privacidade');

    Route::view('/cookies', 'cookies')->name('cookies');
});

Route::domain(env('SHORT_DOMAIN'))->group(function () {
    Route::redirect('/', env('APP_URL'));

    Route::prefix('amazon')->group(function () {
        Route::redirect('/', '/redirect?url=https://www.amazon.com.br/');

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.amazon.com.br/gp/product/$product_id");
        });
    });

    Route::prefix('magalu')->group(function () {
        Route::redirect('/', 'https://www.magazinevoce.com.br/magazineofertasleone/');

        Route::get('/{product_id}', function ($product_id) {
            return redirect("https://www.magazinevoce.com.br/magazineofertasleone/p/$product_id");
        });
    });

    Route::prefix('americanas')->group(function () {
        Route::redirect('/', '/redirect?url=https://www.americanas.com.br/');

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.americanas.com.br/produto/$product_id");
        })->whereNumber('product_id');
    });

    Route::prefix('shoptime')->group(function () {
        Route::redirect('/', '/redirect?url=https://www.shoptime.com.br/');

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.shoptime.com.br/produto/$product_id");
        })->whereNumber('product_id');
    });

    Route::prefix('submarino')->group(function () {
        Route::redirect('/', '/redirect?url=https://www.submarino.com.br/');

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.submarino.com.br/produto/$product_id");
        })->whereNumber('product_id');
    });

    Route::prefix('aliexpress')->group(function () {
        Route::redirect('/', '/redirect?url=https://pt.aliexpress.com/');

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://pt.aliexpress.com/item/$product_id.html");
        })->whereNumber('product_id');
    });

    Route::prefix('shopee')->group(function () {
        Route::redirect('/', 'https://shopee.com.br/ofertas.leone.tec.br');

        Route::get('/{product_id}', function ($product_id) {
            return redirect("https://shopee.com.br/product/306527682/$product_id");
        })->whereNumber('product_id');
    });

    Route::get('/{dados}', [Controllers\RedirectController::class, 'shortLink'])->whereAlphaNumeric('dados');
});
