<?php
namespace Promos\Controller\Pages;

use \Promos\Utils;
use \Exception;

/**
 * Pega os cupons e os exibe 
 */
class Cupons extends Page{
  
  /**
   * Gera a página de cupons
   * @param integer $page
   * @return string
   */
  public static function get($page){
    $page = ($page===0)?1:$page;
    $cupons = Utils\API::getCupons();
    $final = ceil(count($cupons)/18);
    $pagination = Utils\Promotions::getPages($page, $final);
    $content = Utils\View::render('pages/promos',[
      'title' => 'Cupons de desconto',
      'page' => $pagination??'',
      'promo' => Utils\Promotions::getCupons($cupons, $page)
      ]);
      
    return Page::getPage('Cupons de desconto - Página '.$page, $content);
  }
}
