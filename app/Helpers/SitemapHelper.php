<?php

namespace App\Helpers;

use App\Models\Page;

/**
 * Gera um sitemap.txt
 */
class SitemapHelper
{

  private static function processId(int $id): array
  {
    switch ($id) {
      case 77:
        $name = 'smartphones';
        break;

      case 2:
        $name = 'informatica';
        break;

      case 1:
        $name = 'eletronicos';
        break;

      case 116:
        $name = 'eletrodomesticos';
        break;

      case 22:
        $name = 'pc';
        break;

      case 194:
        $name = 'bonecas';
        break;

      case 2852:
        $name = 'tv';
        break;

      case 138:
        $name = 'fogao';
        break;

      case 3673:
        $name = 'geladeira';
        break;

      case 3671:
        $name = 'lavaroupas';
        break;

      case 7690:
        $name = 'roupasm';
        break;

      case 7691:
        $name = 'roupasf';
        break;

      case 2735:
        $name = 'talheres';
        break;

      case 2712:
        $name = 'camas';
        break;

      case 2701:
        $name = 'casaedeco';
        break;

      case 2801:
        $name = 'armario';
        break;

      case 2916:
        $name = 'mesas';
        break;

      case 2930:
        $name = 'luz';
        break;
    }

    if (!empty($name)) {
      return ['name' => $name, 'categorias' => true];
    }

    switch ($id) {
      case 5632:
        $name = 'americanas';
        break;

      case 5727:
        $name = 'girafa';
        break;

      case 5766:
        $name = 'submarino';
        break;

      case 5644:
        $name = 'shoptime';
        break;

      case 7863:
        $name = 'brandili';
        break;

      case 6358:
        $name = 'usaflex';
        break;

      case 6078:
        $name = 'electrolux';
        break;

      case 7460:
        $name = 'itatiaia';
        break;

      case 5936:
        $name = 'brastemp';
        break;

      case 6117:
        $name = 'positivo';
        break;

      case 6373:
        $name = 'etna';
        break;

      case 6104:
        $name = 'repassa';
        break;
    }

    return ['name' => $name ?? '', 'categorias' => false];
  }

  public static function generate(): void
  {
    $arquivo = public_path('sitemap.txt');

    $a = [
      route('home'), route('privacidade'), route('cookies'), route('notificacoes'), route('lojas'), route('categorias'), route('cupons'),
      route('loja', 'americanas'), route('loja', 'girafa'), route('loja', 'magalu'), route('loja', 'submarino'), route('loja', 'shoptime'), route('loja', 'brandili'), route('loja', 'usaflex'), route('loja', 'electrolux'), route('loja', 'submarino'), route('loja', 'itatiaia'), route('loja', 'brastemp'), route('loja', 'positivo'), route('loja', 'etna'), route('loja', 'repassa'),
      route('categoria', 'smartphones'), route('categoria', 'informatica'), route('categoria', 'eletronicos'), route('categoria', 'eletrodomesticos'), route('categoria', 'pc'), route('categoria', 'bonecas'), route('categoria', 'tv'), route('categoria', 'fogao'), route('categoria', 'geladeira'), route('categoria', 'lavaroupas'), route('categoria', 'roupasm'), route('categoria', 'roupasf'), route('categoria', 'talheres'), route('categoria', 'camas'), route('categoria', 'casaedeco'), route('categoria', 'armario'), route('categoria', 'mesas'), route('categoria', 'luz')
    ];

    $pages = Page::all();

    if (!empty($pages)) {
      foreach ($pages as $page) {
        if ($page->id == 9999) {
          continue;
        }

        $dados = self::processId($page->id);
        if ($page->total > 1500) {
          $page->total = 1000;
        }

        for ($i = 1; $i != $page->total; $i++) {
          $a[] = route(($dados['categorias']) ? 'categoria' : 'loja', $dados['name']) . '/' . $i;
        }
      }
    }

    file_put_contents($arquivo, implode("\n", $a));
  }
}
