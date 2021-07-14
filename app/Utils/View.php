<?php
namespace Leone\Promos\Utils;

/**
 * Classe responsável por gerar a view do site
 */
class View{
  
  /**
   * Método responsável por retornar o conteúdo de uma view
   * @param string $view
   * @return string
   */
  private static function getContentView($view){
    $file = __DIR__.'/../../resources/view/'.$view.'.html';
    return file_exists($file)?file_get_contents($file):'';
  }
  
  /**
   * Método responsável por retornar o conteúdo processado de uma view
   * @param string $view
   * @param array $vars (string/integer)
   * @return string
   */
  public static function render($view, $vars = []){
    $vars['URL'] = $_SERVER['HOST'].$_SERVER['REQUEST_URI'];
    $vars['public_recaptcha_v3'] = $_ENV['PUBLIC_RECAPTCHA_V3'];
    $vars['ano'] = date("Y");
    $contentView = self::getContentView($view);
    $keys = array_keys($vars);
    $keys = array_map(function ($item){
      return '{{'.$item.'}}';
    }, $keys);
    return str_replace($keys, array_values($vars), $contentView);
  }
}