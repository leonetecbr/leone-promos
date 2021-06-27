<?php
namespace Promos\Controller\Pages;

use \Promos\Utils\View;

/**
 * Classe responsável por gerar a página genérica
 */
class Page{
  
  /**
   * Método responsável por retornar o conteúdo da página genérica processada.
   * @return string
   */
  public static function getPage($title, $content, $headers = ''){
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