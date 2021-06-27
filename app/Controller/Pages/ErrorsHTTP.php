<?php
namespace Promos\Controller\Pages;

use \Promos\Utils;

/**
 * Classe responsável por gerar as páginas de erro
 */
class ErrorsHTTP extends Page{
  
  /**
   * Método responsável por retornar o conteúdo da página de erro 404 processada.
   * @return string
   */
  public static function getNotFound(){
    $content = Utils\View::render('pages/notfound');
      
    return Page::getPage('Não encontrada', $content);
  }
  
  /**
   * Método responsável por retornar o conteúdo da página de erro 405 processada.
   * @return string
   */
  public static function getNotAllowed(){
    $content = Utils\View::render('pages/notallowed');
      
    return Page::getPage('Metódo não permitido', $content);
  }
  
  
  /**
   * Método responsável por retornar o conteúdo da página de erro 401 processada.
   * @return string
   */
  public static function getUnauthorized(){
    $content = Utils\View::render('pages/unauthorized');
    return Page::getPage('Não autorizado', $content);
  }
  
    /**
   * Método responsável por retornar o conteúdo da página de erro 403 processada.
   * @return string
   */
  public static function getForbidden(){
    $content = Utils\View::render('pages/forbidden');
    return Page::getPage('Proibido', $content);
  }
  
   /**
   * Método responsável por retornar o conteúdo da página de erro 500 processada.
   * @return string
   */
  public static function getInternalError(){
    $content = Utils\View::render('pages/internalerror');
    return Page::getPage('Erro interno', $content);
  }
  
   /**
   * Método responsável por direcionar o erro ao seu devido método.
   * @param integer $code
   * @return string
   */
  public static function getCode($code=200, $msg=''){
    switch ($code) {
      case 401:
        return self::getUnauthorized();
        break;
      
      case 403:
        return self::getForbidden();
        break;
      
      case 404:
        return self::getNotFound();
        break;
        
      case 405:
        return self::getNotAllowed();
        break;
      
      case 500:
        return self::getInternalError();
        break;
      
      default:
        return $msg;
        break;
    }
  }
}