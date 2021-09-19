<?php
namespace Leone\Promos\Controller\Pages;

use \Leone\Promos\Utils\View;

/**
 * Classe responsável por gerar a página genérica
 */
class Page{
  
  /**
   * Método responsável por retornar o conteúdo da página genérica processada.
   * @params string $title, $headers, $content
   * @return string
   */
  public static function getPage(string $title, string $content, string $headers = '') : string{
    $dados = [
      'content' => $content,
      'title' => $title,
      'headers' => $headers,
      'notify' => (stripos($_SERVER['REQUEST_URI'], '/notificacoes')===0)?'':View::render('widgets/notify')
      ];
    
    $dados['aviso'] = empty($_COOKIE['accept'])?View::render('widgets/aviso'):'';
    $dados['robots'] = (stripos($_SERVER['REQUEST_URI'], '/search')===0)?'noindex':'index, follow';
    return View::render('pages/page', $dados);
  }
}