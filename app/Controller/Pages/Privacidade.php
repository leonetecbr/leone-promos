<?php
namespace Leone\Promos\Controller\Pages;

use \Leone\Promos\Utils;

/**
 * Classe responsável por gerar a página de privacidade
 */
class Privacidade extends Page{
  
  /**
   * Método responsável por retornar o conteúdo da página de privacidade processada.
   * @return string
   */
  public static function getPrivacidade(){
    $content = Utils\View::render('pages/privacidade');
      
    return Page::getPage('Políticas de privacidade', $content);
  }
}