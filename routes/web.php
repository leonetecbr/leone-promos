<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Helpers\RedirectHelper;

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

    Route::get('/{categoria}/{page?}', [Controllers\CategoriasController::class, 'process'])->where('categoria', '[a-z]+')->where('page', '^[1-9]+[0-9]*$')->name('categoria');
  });

  Route::prefix('lojas')->group(function () {
    Route::get('/', [Controllers\LojasController::class, 'get'])->name('lojas');

    Route::get('/{loja}/{page?}', [Controllers\LojasController::class, 'process'])->where('loja', '[a-z]+')->where('page', '^[1-9]+[0-9]*$')->name('loja');
  });

  Route::get('/cupons/{page?}', [Controllers\CuponsController::class, 'get'])->where('page', '^[1-9]+[0-9]*$')->name('cupons');

  Route::match(['get', 'post'], '/search/{query}/{page?}', [Controllers\SearchController::class, 'search'])->where('query', '[\w ]+')->where('page', '^[1-9]+[0-9]*$')->name('pesquisa');

  Route::get('/redirect', [Controllers\RedirectController::class, 'get']);

  Route::post('/redirect', [Controllers\RedirectController::class, 'api']);

  Route::get('/notificacoes', [Controllers\NotificationController::class, 'get'])->name('notificacoes');

  Route::post('/register', [Controllers\NotificationController::class, 'register']);

  Route::prefix('prefer')->group(function () {
    Route::post('/get', [Controllers\NotificationController::class, 'getPrefer']);

    Route::post('/set', [Controllers\NotificationController::class, 'setPrefer']);
  });

  Route::get('/login', [Controllers\UserController::class, 'login'])->name('login');

  Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [Controllers\UserController::class, 'logout'])->name('logout');

    Route::prefix('admin')->group(function () {
      Route::post('/', [Controllers\UserController::class, 'auth'])->withoutMiddleware('auth');

      Route::get('/', [Controllers\AdminController::class, 'get'])->name('dashboard');

      Route::prefix('promos')->group(function () {
        Route::get('/', [Controllers\TopPromosController::class, 'list'])->name('listpromos');

        Route::get('/new', [Controllers\TopPromosController::class, 'new']);

        Route::get('/edit/{id}', [Controllers\TopPromosController::class, 'edit'])->where('id', '[0-9]+');

        Route::get('/delete/{id}', [Controllers\TopPromosController::class, 'delete'])->where('id', '[0-9]+');

        Route::post('/save', [Controllers\TopPromosController::class, 'save']);
      });

      Route::prefix('notify')->group(function () {
        Route::get('/', [Controllers\NotificationController::class, 'getAdmin']);

        Route::post('/send', [Controllers\NotificationController::class, 'send']);

        Route::get('/history/{page?}', [Controllers\SendedNotificationController::class, 'get'])->name('notify.history');
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
      return redirect('https://www.amazon.com.br/?tag=leonepromos-20');
    });

    Route::get('/{product_id}', function ($product_id) {
      return redirect('https://www.amazon.com.br/gp/product/' . $product_id . '?tag=leonepromos08-20');
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
      return redirect(RedirectHelper::processAwin('https://www.soubarato.com.br/', 23281, $_ENV['ID_AFILIADO_B2W']));
    });

    Route::get('/{product_id}', function ($product_id) {
      return redirect(RedirectHelper::processAwin("https://www.soubarato.com.br/produto/{$product_id}", 23281, $_ENV['ID_AFILIADO_B2W']));
    })->where('product_id', '[0-9]+');
  });

  Route::prefix('americanas')->group(function () {
    Route::get('/', function () {
      return redirect(RedirectHelper::processAwin('https://www.americanas.com.br/', 22193, $_ENV['ID_AFILIADO_B2W']));
    });

    Route::get('/{product_id}', function ($product_id) {
      return redirect(RedirectHelper::processAwin("https://www.americanas.com.br/produto/{$product_id}", 22193, $_ENV['ID_AFILIADO_B2W']));
    })->where('product_id', '[0-9]+');
  });

  Route::prefix('shoptime')->group(function () {
    Route::get('/', function () {
      return redirect(RedirectHelper::processAwin('https://www.shoptime.com.br/', 22194, $_ENV['ID_AFILIADO_B2W']));
    });

    Route::get('/{product_id}', function ($product_id) {
      return redirect(RedirectHelper::processAwin("https://www.shoptime.com.br/produto/{$product_id}", 22194, $_ENV['ID_AFILIADO_B2W']));
    })->where('product_id', '[0-9]+');
  });

  Route::prefix('submarino')->group(function () {
    Route::get('/', function () {
      return redirect(RedirectHelper::processAwin('https://www.submarino.com.br/', 22195, $_ENV['ID_AFILIADO_B2W']));
    });

    Route::get('/{product_id}', function ($product_id) {
      return redirect(RedirectHelper::processAwin("https://www.submarino.com.br/produto/{$product_id}", 22195, $_ENV['ID_AFILIADO_B2W']));
    })->where('product_id', '[0-9]+');
  });

  Route::prefix('aliexpress')->group(function () {
    Route::get('/', function () {
      return redirect(RedirectHelper::processAwin('https://pt.aliexpress.com/', 18879));
    });
    
    Route::get('/{product_id}', function ($product_id) {
      return redirect(RedirectHelper::processAwin("https://pt.aliexpress.com/item/{$product_id}.html", 18879));
    })->where('product_id', '[0-9]+');
  });

  Route::prefix('shopee')->group(function () {
    Route::get('/', function () {
      return redirect('https://shopee.com.br/ofertas.leone.tec.br');
    });

    Route::get('/{product_id}', function ($product_id) {
      return redirect("https://shopee.com.br/product/306527682/{$product_id}");
    })->where('product_id', '[0-9]+');
  });

  Route::get('/c/{cupom_id}', function ($cupom_id) {
    $page = ceil((abs(intval($cupom_id)) + 1) / 18);
    return redirect(env('APP_URL') . '/cupons/' . $page . '#cupom-' . $cupom_id);
  })->where('cupom_id', '[0-9]+');

  Route::get('/o/{cat_id}-{page}-{oferta_id}', function ($cat_id, $page, $oferta_id) {
    return redirect(env('APP_URL') . '/' . RedirectHelper::processPage(intval($cat_id), intval($page), intval($oferta_id)));
  })->where('cat_id', '[0-9]+')->where('page', '[0-9]+')->where('oferta_id', '[0-9]+');
});