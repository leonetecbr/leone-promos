<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Page;
use App\Models\TopStores;
use Exception;

/**
 * Gera o sitemap
 */
class SitemapHelper
{

    /**
     * Gera um sitemap.txt
     * @return void
     * @throws Exception
     */
    public static function generate(): void
    {
        $arquivo = public_path('sitemap.txt');

        $stores = TopStores::all()->toArray();
        $categories = Category::all()->toArray();

        $a = [
            route('home'),
            route('privacidade'),
            route('cookies'),
            route('notificacoes'),
            route('lojas'),
            route('categorias'),
            route('cupons'),
        ];

        foreach ($stores as $store) {
            $a[] = route('loja', $store['name']);
        }

        foreach ($categories as $category) {
            $a[] = route('categoria', $category['name']);
        }

        $endPage = Page::all();

        if (!empty($endPage)) {
            foreach ($endPage as $page) {
                if ($page->id == 9999) {
                    continue;
                }

                if ($page->total > 1000) {
                    $page->total = 1000;
                }

                for ($i = 2; $i != $page->total; $i++) {
                    $path = RedirectHelper::processPage($page->id, $i, null, true);

                    if (empty($path)) {
                        break;
                    }

                    $a[] = env('APP_URL') . '/' . $path;
                }
            }
        }

        file_put_contents($arquivo, implode("\n", $a));
    }
}
