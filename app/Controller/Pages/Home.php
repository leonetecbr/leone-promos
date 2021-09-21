<?php
namespace Leone\Promos\Controller\Pages;

use Leone\Promos\Utils;

/**
 * Classe responsável por gerar a página inicial
 */
class Home extends Page{
  
  /**
   * Método responsável por retornar o conteúdo da página inicial processada.
   * @return string
   */
  public static function getHome(): string{
    $ofertas = Utils\API::getPromo(0);
    $content = Utils\View::render('pages/home',[
      'top_promos' => Utils\Promotions::getPromos($ofertas, 0)
      ]);
      
    return Page::getPage('Início', $content);
  }
}