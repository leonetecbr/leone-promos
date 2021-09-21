<?php
namespace Leone\Promos\Controller\Pages;

use Leone\Promos\Utils;

/**
 * Classe responsável por gerar a páginas de aviso de remoção de lojas
 */
class Removed extends Page{
  
  /**
   * Método responsável por retornar o conteúdo da página "Amazon foi removida" processada
   * @return string
   */
  public static function getAmazon(): string{
    $content = Utils\View::render('pages/amazon');
      
    return Page::getPage('Amazon foi removida', $content);
  }
}