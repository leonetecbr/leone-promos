<?php

namespace App\Helpers;

class RedirectHelper
{
  /**
   * Gera os links de afiliado para produtos da Magazine Luiza
   * @param string $url
   * @return string
   */
  public static function processMagalu(string $url): string
  {
    if (strpos($url, 'https://www.magazinevoce.com.br') !== 0) {
      $partes = explode('/', $url, 7);
      return 'https://www.magazinevoce.com.br/magazineofertasleone/p/' . $partes[3] . '/' . $partes[5];
    } else {
      $partes = explode('/', $url, 7);
      $partes[3] = 'magazineofertasleone';
      return implode('/', $partes);
    }
  }


  /**
   * Gera os links de afiliado para protudos das lojas parceira pelo awin, por enquanto apenas Aliexpress, Extra, Ponto e Casas Bahia
   * @param string $url
   * @param integer $advertiserId
   * @return string
   */
  public static function processAwin(string $url, int $advertiserId, $uid = null): string
  {
    if (empty($uid)) {
      $uid = $_ENV['ID_AFILIADO_AWIN'];
    }

    return 'https://www.awin1.com/cread.php?awinmid=' . $advertiserId . '&awinaffid=' . $uid . '&clickref=deeplink&ued=' . urlencode($url);
  }

  /**
   * Gera os links de afiliado para produtos das demais lojas parceiras pela Lomadee
   * @param string $url
   * @return string
   */
  public static function processLomadee(string $url): string
  {
    return 'https://redir.lomadee.com/v2/deeplink?sourceId=' . $_ENV['SOURCE_ID_LOMADEE'] . '&url=' . urlencode($url);
  }
  /**
   * Encontra o link da página da ofertas
   *
   * @param integer $cat_id
   * @param integer $page
   * @param integer $oferta_id
   * @return string
   */
  public static function processPage(int $cat_id, int $page, int $oferta_id): string
  {
    switch ($cat_id) {
      case 77:
        $path = 'categorias/smartphones';
        break;

      case 2:
        $path = 'categorias/informatica';
        break;

      case 1:
        $path = 'categorias/eletronicos';
        break;

      case 116:
        $path = 'categorias/eletrodomesticos';
        break;

      case 22:
        $path = 'categorias/pc';
        break;

      case 194:
        $path = 'categorias/bonecas';
        break;

      case 2852:
        $path = 'categorias/tv';
        break;

      case 138:
        $path = 'categorias/fogao';
        break;

      case 3673:
        $path = 'categorias/geladeira';
        break;

      case 3671:
        $path = 'categorias/lavaroupas';
        break;

      case 7690:
        $path = 'categorias/roupasm';
        break;

      case 7691:
        $path = 'categorias/roupasf';
        break;

      case 2735:
        $path = 'categorias/talheres';
        break;

      case 2712:
        $path = 'categorias/camas';
        break;

      case 2701:
        $path = 'categorias/casaedeco';
        break;

      case 2916:
        $path = 'categorias/mesas';
        break;


      case 5632:
        $path = 'lojas/americanas';
        break;

      case 5766:
        $path = 'lojas/submarino';
        break;

      case 5644:
        $path = 'lojas/shoptime';
        break;

      case 7863:
        $path = 'lojas/brandili';
        break;

      case 6358:
        $path = 'lojas/usaflex';
        break;

      case 6078:
        $path = 'lojas/electrolux';
        break;

      case 7460:
        $path = 'lojas/itatiaia';
        break;

      case 5936:
        $path = 'lojas/brastemp';
        break;

      case 6117:
        $path = 'lojas/positivo';
        break;

      case 6373:
        $path = 'lojas/etna';
        break;

      case 6104:
        $path = 'lojas/repassa';
        break;

      case 0:
        $path = '';
        break;

      default:
        return '';
    }

    $path .= ($page === 1) ? '' : '/' . $page;
    $path .= '#' . $cat_id . '_' . $page . '_' . $oferta_id;

    return $path;
  }
}
