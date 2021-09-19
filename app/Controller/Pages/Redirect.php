<?php
namespace Leone\Promos\Controller\Pages;

use Leone\Promos\Http\Response;
use Exception;

/**
 * Gera os links de afiliado para as lojas  
 */
class Redirect{
  
  
  /**
   * Gera os links de afiliado para produtos da Magazine Luiza
   * @param string $url
   * @return string
   */
  private static function processMagalu(string $url) : string{
    if (strpos($url, 'https://www.magazinevoce.com.br/')!==0) {
      $partes = explode('/', $url, 7);
      return 'https://www.magazinevoce.com.br/magazineofertasleone/p/'.$partes[3].'/'.$partes[5];
    }else{
      $partes = explode('/', $url, 7);
      $partes[3]='magazineofertasleone';
      return implode('/', $partes);
    }
  }
  
  
  /**
   * Gera os links de afiliado para protudos das lojas parceira pelo awin, por enquanto apenas Aliexpress, Extra, Ponto e Casas Bahia
   * @param string $url
   * @param integer $advertiserId
   * @return string
   */
  private static function processAwin(string $url, int $advertiserId) : string{
    return 'https://www.awin1.com/cread.php?awinmid='.$advertiserId.'&awinaffid='.$_ENV['ID_AFILIADO_AWIN'].'&clickref=deeplink&ued='.urlencode($url);
  }
  
  /**
   * Gera os links de afiliado para produtos das demais lojas parceiras pela Lomadee
   * @param string $url
   * @return string
   */
  private static function processLomadee(string $url) : string{
    if ((strpos($url, 'https://www.amazon.com.br')===0 || strpos($url, 'https://amazon.com.br')===0) && strpos($url, '/ref=')!== false) {
      $url = strstr($url, '/ref', true);
    }
    
    return 'https://redir.lomadee.com/v2/deeplink?sourceId='.$_ENV['SOURCE_ID_LOMADEE'].'&url='.urlencode($url);
  }
  
  /**
   * Procesa a URL recebida, encaminha para o método responsável e retorna o link já com parâmetros de afiliados
   * @return string URN
   */
  public static function process(string $url='') : string{
    if (empty($url)) {
      $url = strtolower($_GET['url']??'');
    }
    
    try{
      if (empty($url) || strpos($url, 'https://')!==0) {
        throw new Exception;
      }
      if (strpos($url, '?')!== false) {
        $url = strstr($url, '?', true);
      }
      
      if (strpos($url, 'https://www.amazon.com.br/')===0 || strpos($url, 'https://amazon.com.br/')===0) {
        $to = '/amazon';
      }elseif (strpos($url, 'https://m.magazineluiza.com.br')===0 || strpos($url, 'https://www.magazineluiza.com.br')===0 || strpos($url, 'https://magazineluiza.com.br')===0 || strpos($url, 'https://www.magazinevoce.com.br')===0) {
        $to = self::processMagalu($url);
      } elseif(strpos($url, 'https://mbest.aliexpress.com')===0 || strpos($url, 'https://m.pt.aliexpress.com')===0 || strpos($url, 'https://best.aliexpress.com')===0 || strpos($url, 'https://pt.aliexpress.com')===0 || strpos($url, 'https://aliexpress.com')===0 || strpos($url, 'https://m.aliexpress.com')===0){
        $to = self::processAwin($url, 18879);
      }elseif(strpos($url, 'https://m.pontofrio.com.br')===0 || strpos($url, 'https://www.pontofrio.com.br')===0 || strpos($url, 'https://pontofrio.com.br')===0){
        $to = self::processAwin($url, 17621);
      }elseif( strpos($url, 'https://m.extra.com.br')===0 || strpos($url, 'https://www.extra.com.br')===0 || strpos($url, 'https://extra.com.br')===0){
        $to = self::processAwin($url, 17874);
      }elseif (strpos($url, 'https://m.casasbahia.com.br')===0 || strpos($url, 'https://www.casasbahia.com.br')===0 || strpos($url, 'https://casasbahia.com.br')===0) {
        $to = self::processAwin($url, 17629);
      }else{
        $to = self::processLomadee($url);
      }
    } catch (Exception $e){
      $to = '/';
    } finally{
      return $to;
    }
  }
}