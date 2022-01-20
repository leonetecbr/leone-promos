<?php

namespace App\Helpers;

use App\Models\Page;

/**
 * Gera um sitemap.txt
 */
class SitemapHelper
{

  public static function generate(): void
  {
    $arquivo = public_path('sitemap.txt');

    $a = [
      route('home'), route('privacidade'), route('cookies'), route('notificacoes'), route('lojas'), route('categorias'), route('cupons'),
      route('loja', 'americanas'), route('loja', 'magalu'), route('loja', 'submarino'), route('loja', 'shoptime'), route('loja', 'brandili'), route('loja', 'usaflex'), route('loja', 'electrolux'), route('loja', 'submarino'), route('loja', 'itatiaia'), route('loja', 'brastemp'), route('loja', 'positivo'), route('loja', 'etna'), route('loja', 'repassa'),
      route('categoria', 'smartphones'), route('categoria', 'informatica'), route('categoria', 'eletronicos'), route('categoria', 'eletrodomesticos'), route('categoria', 'pc'), route('categoria', 'bonecas'), route('categoria', 'tv'), route('categoria', 'fogao'), route('categoria', 'geladeira'), route('categoria', 'lavaroupas'), route('categoria', 'roupasm'), route('categoria', 'roupasf'), route('categoria', 'talheres'), route('categoria', 'camas'), route('categoria', 'casaedeco'), route('categoria', 'mesas')
    ];

    $pages = Page::all();

    if (!empty($pages)) {
      foreach ($pages as $page) {
        if ($page->id == 9999) {
          continue;
        }

        if ($page->total > 1500) {
          $page->total = 1000;
        }

        for ($i = 2; $i != $page->total; $i++) {
          $path = RedirectHelper::processPage($page->id, $i);

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
