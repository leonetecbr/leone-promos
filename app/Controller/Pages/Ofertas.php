<?php
namespace Leone\Promos\Controller\Pages;

use Exception;

/**
 * Classe responsável por redirecionar para a oferta correspondente
 */
class Ofertas{
  
  /**
   * Encontra a URL correta para fazer o redirecionamento
   * @params integer $cat_id $page $oferta_id
   * @return string
   */
  public static function process(int $cat_id, int $page, int $oferta_id): string{
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
        
      case 2801:
        $path = 'categorias/armario';
        break;
        
      case 2916:
        $path = 'categorias/mesas';
        break;
        
      case 2930:
        $path = 'categorias/luz';
        break;
        
      case 5992:
        $path = 'lojas/amazon';
        break;
        
      case 5632:
        $path = 'lojas/americanas';
        break;
        
      case 5727:
        $path = 'lojas/girafa';
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
        
      default:
        $path = '';
        break;
    }
    $path .= ($page===1)?'':'/'.$page;
    $path .= '#'.$cat_id.'_'.$page.'_'.$oferta_id;
    return $path;
  }
}