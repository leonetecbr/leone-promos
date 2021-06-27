<?php
namespace Promos\Controller\Pages;

use \Promos\Utils;
use \Exception;

/**
 * Processa as pesquisas
 */
class Search extends Page{
  
  /**
   * Processa a pesquisa e retorna o resultado
   * @return string
   */
  public static function process($q, $page){
    try{
      $q = filter_var($q, FILTER_SANITIZE_STRING);
      $type = $_POST['type']??'';
      $type = ($type!=='v2')?'v3':'v2';
      $g_response = $_POST['g-recaptcha-response']??'';
      $page = ($page===0)?1:$page;
      if (empty($q) || mb_strlen($q, 'UTF-8')<3 || mb_strlen($q, 'UTF-8')>64){
        throw new Exception('Pesquisa inválida!');
      }
      
      if (empty($g_response) || strlen($g_response)<20){
        throw new Exception('Não temos certeza que você não é um robô, marque a caixa de verificação abaixo para continuar com sua pesquisa:', 499);
      }
      
      $robot = new Utils\Recaptcha($g_response, $type);
      $isRobot = ($type==='v2')?$robot->isOrNotV2():$robot->isOrNotV3();
      if($isRobot){
        throw new Exception('Não temos certeza que você não é um robô, marque a caixa de verificação abaixo para continuar com sua pesquisa:', 499);
      }
      $dado = Utils\API::search($q, $page);
      $ofertas = $dado['offers'];
      $pages = $dado['pagination']['totalPage'];
      $pagination = Utils\Promotions::getPages($page, $pages);
      $text = Utils\Promotions::getPromos($ofertas, 000, $page);
    } catch (Exception $e){
      $text = '<p class="fs-12 erro">'.$e->getMessage().'</p>';
      if ($e->getCode()===499) {
        $text .= '<div class="center container mt-2"><form id="checkbox" method="post"><input type="hidden" name="type" value="v2"><div class="g-recaptcha" data-sitekey="6LeuK5UaAAAAAGlPXLMsCh9L0XpH1qOHR285Ho2m" data-callback="submit"></div></form></div>';
        $headers = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
      }
    } finally{
      $content = Utils\View::render('pages/promos',[
        'title' => 'Pesquisa por "'.$q.'"',
        'page' => $pagination??'',
        'promo' => $text
      ]);
      return Page::getPage('Pesquisa por: '.$q, $content, $headers??'');
    }
  }
}