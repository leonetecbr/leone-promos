<?php
namespace Leone\Promos\Controller\Pages;

use \Leone\Promos\Utils;

/**
 * Classe responsável por gerar a página de cookies
 */
class Cookies extends Page{
  
  /**
   * Método responsável por retornar o conteúdo da página de cookies processada.
   * @return string
   */
  public static function getCookies(){
    $content = Utils\View::render('pages/cookies');
      
    return Page::getPage('Políticas de cookies', $content);
  }
}