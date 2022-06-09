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

Route::domain(env('APP_DOMAIN'))->group(function () {

    Route::get('/', Controllers\HomeController::class)->name('home');

    Route::prefix('categorias')->group(function () {
        Route::get('/', [Controllers\CategoriasController::class, 'get'])->name('categorias');

        Route::get('/{categoria}/{page?}', [Controllers\CategoriasController::class, 'process'])->whereAlpha('categoria')->where('page', '^[1-9]+[0-9]*$')->name('categoria');
    });

    Route::prefix('lojas')->group(function () {
        Route::get('/', [Controllers\LojasController::class, 'get'])->name('lojas');

        Route::get('/{loja}/{page?}', [Controllers\LojasController::class, 'process'])->whereAlpha('loja')->where('page', '^[1-9]+[0-9]*$')->name('loja');
    });

    Route::get('/cupons/{page?}', [Controllers\CuponsController::class, 'get'])->where('page', '^[1-9]+[0-9]*$')->name('cupons');

    Route::match(['get', 'post'], '/search/{query}/{page?}', [Controllers\SearchController::class, 'search'])->where(['query' => '[\w ]+', 'page' => '^[1-9]+[0-9]*$'])->name('pesquisa');

    Route::get('/redirect', [Controllers\RedirectController::class, 'get']);

    Route::post('/redirect', [Controllers\RedirectController::class, 'api']);

    Route::prefix('notificacoes')->group(function () {
        Route::get('/', [Controllers\NotificationController::class, 'get'])->name('notificacoes');

        Route::post('/manage', [Controllers\NotificationController::class, 'userManage']);
    });

    Route::prefix('prefer')->group(function () {
        Route::post('/get', [Controllers\NotificationController::class, 'getPrefer']);

        Route::post('/set', [Controllers\NotificationController::class, 'setPrefer'])->name('prefer.set');
    });

    Route::get('/rastreio', [Controllers\RastreioController::class, 'get'])->name('rastreio');

    Route::get('/login', [Controllers\UserController::class, 'login'])->name('login');

    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [Controllers\UserController::class, 'logout'])->name('logout');

        Route::prefix('admin')->group(function () {
            Route::post('/', [Controllers\UserController::class, 'auth'])->withoutMiddleware('auth');

            Route::get('/', [Controllers\AdminController::class, 'get'])->name('dashboard');

            Route::prefix('promos')->group(function () {
                Route::get('/', [Controllers\TopPromosController::class, 'list'])->name('promos.list');

                Route::get('/new', [Controllers\TopPromosController::class, 'new'])->name('promos.new');

                Route::get('/edit/{id}', [Controllers\TopPromosController::class, 'edit'])->whereNumber('id');

                Route::get('/delete/{id}', [Controllers\TopPromosController::class, 'delete'])->whereNumber('id')->name('promos.delete');

                Route::post('/save', [Controllers\TopPromosController::class, 'save'])->name('promos.save');
            });

            Route::prefix('notification')->group(function () {
                Route::get('/', [Controllers\NotificationController::class, 'getAdmin'])->name('notification.new');

                Route::post('/send', [Controllers\NotificationController::class, 'send'])->name('notification.send');

                Route::get('/history/{page?}', [Controllers\SendedNotificationController::class, 'get'])->name('notification.history');
            });

            Route::prefix('lojas')->group(function () {
                Route::get('/new', [Controllers\LojasController::class, 'new'])->name('lojas.new');

                Route::post('/save', [Controllers\LojasController::class, 'save'])->name('lojas.save');
            });
        });
    });

    Route::get('/403', function () {
        return abort(403);
    });

    Route::get('/privacidade', function () {
        return view('privacidade');
    })->name('privacidade');

    Route::get('/cookies', function () {
        return view('cookies');
    })->name('cookies');
});

Route::domain(env('SHORT_DOMAIN'))->group(function () {
    Route::get('/', function () {
        return redirect(env('APP_URL'));
    });

    Route::prefix('amazon')->group(function () {
        Route::get('/', function () {
            return redirect('/redirect?url=https://www.amazon.com.br/');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect('/redirect?url=https://www.amazon.com.br/gp/product/' . $product_id);
        });
    });

    Route::prefix('magalu')->group(function () {
        Route::get('/', function () {
            return redirect('https://www.magazinevoce.com.br/magazineofertasleone/');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect("https://www.magazinevoce.com.br/magazineofertasleone/p/{$product_id}");
        });
    });

    Route::prefix('soub')->group(function () {
        Route::get('/', function () {
            return redirect('/redirect?url=https://www.soubarato.com.br/');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.soubarato.com.br/produto/{$product_id}");
        })->whereNumber('product_id');
    });

    Route::prefix('americanas')->group(function () {
        Route::get('/', function () {
            return redirect('/redirect?url=https://www.americanas.com.br/');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.americanas.com.br/produto/{$product_id}");
        })->whereNumber('product_id');
    });

    Route::prefix('shoptime')->group(function () {
        Route::get('/', function () {
            return redirect('/redirect?url=https://www.shoptime.com.br/');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.shoptime.com.br/produto/{$product_id}");
        })->whereNumber('product_id');
    });

    Route::prefix('submarino')->group(function () {
        Route::get('/', function () {
            return redirect('/redirect?url=https://www.submarino.com.br/');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://www.submarino.com.br/produto/{$product_id}");
        })->whereNumber('product_id');
    });

    Route::prefix('aliexpress')->group(function () {
        Route::get('/', function () {
            return redirect('/redirect?url=https://pt.aliexpress.com/');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect("/redirect?url=https://pt.aliexpress.com/item/{$product_id}.html");
        })->whereNumber('product_id');
    });

    Route::prefix('shopee')->group(function () {
        Route::get('/', function () {
            return redirect('https://shopee.com.br/ofertas.leone.tec.br');
        });

        Route::get('/{product_id}', function ($product_id) {
            return redirect("https://shopee.com.br/product/306527682/{$product_id}");
        })->whereNumber('product_id');
    });

    Route::get('/{dados}', [Controllers\RedirectController::class, 'shortLink'])->whereAlphaNumeric('dados');
});
