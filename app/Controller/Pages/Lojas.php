<?php
namespace Leone\Promos\Controller\Pages;

use Leone\Promos\Utils;
use Exception;
use Leone\Promos\Http\Response;

/**
 * Processa todas as páginas de categoria
 */
class Lojas extends Page{
  
  /**
   * Gera a página com a lista das categorias
   * @return string
   */
  public static function get() : string{
    $content = Utils\View::render('pages/lojas');
      
    return Page::getPage('Lojas', $content);
  }
  
  /*
   * Processa as páginas das lojas
   * @param string $loja
   * @param integer $page
   * @return string
   */
  public static function process(string $loja, int $page) : string{
    try{
      $page = ($page===0)?1:$page;
      switch ($loja) {
        case 'magalu':
          $redirect = new Response(303);
          $redirect->addHeader('Location', 'https://www.magazinevoce.com.br/magazineofertasleone/');
          $redirect->sendResponse();
        
        case 'amazon':
          $redirect = new Response(303);
          $redirect->addHeader('Location', '/amazon');
          $redirect->sendResponse();
          break;
        
        case 'americanas':
          $dados['loja'] = 5632;
          $dados['title'] = 'Americanas';
          break;
        
        case 'girafa':
          $dados['loja'] = 5727;
          $dados['title'] = 'Girafa';
          break;
        
        case 'submarino':
          $dados['loja'] = 5766;
          $dados['title'] = 'Submarino';
          break;
        
        case 'shoptime':
          $dados['loja'] = 5644;
          $dados['title'] = 'Shoptime';
          break;
        
        case 'brandili':
          $dados['loja'] = 7863;
          $dados['title'] = 'Brandili';
          break;
        
        case 'usaflex':
          $dados['loja'] = 6358;
          $dados['title'] = 'Usaflex';
          break;
        
        case 'electrolux':
          $dados['loja'] = 6078;
          $dados['title'] = 'Electrolux';
          break;
        
        case 'itatiaia':
          $dados['loja'] = 7460;
          $dados['title'] = 'Itatiaia';
          break;
        
        case 'brastemp':
          $dados['loja'] = 5936;
          $dados['title'] = 'Brastemp';
          break;
        
        case 'positivo':
          $dados['loja'] = 6117;
          $dados['title'] = 'Positivo';
          break;
        
        case 'etna':
          $dados['loja'] = 6373;
          $dados['title'] = 'Etna';
          break;
        
        case 'repassa':
          $dados['loja'] = 6104;
          $dados['title'] = 'Repassa';
          break;
        
        default:
          throw new Exception('Loja não encontrada!');
          break;
      }
      $dado = Utils\API::getPromo(999, $page, $dados['loja']);
      $ofertas = $dado['offers'];
      $pages = $dado['pagination']['totalPage'];
      $text = Utils\Promotions::getPromos($ofertas, $dados['loja'], $page);
      $pagination = Utils\Promotions::getPages($page, $pages);
    }catch (Exception $e){
      $dados['title'] = 'Não encontrada';
      $text = '<p class="fs-12 erro">'.$e->getMessage().'</p>';
    } finally{
      $content = Utils\View::render('pages/promos',[
        'title' => $dados['title'],
        'page' => $pagination??'',
        'promo' => $text
      ]);
      return Page::getPage('Loja: '.$dados['title'].' - Página '.$page, $content);
    }
  }
}
