<?php
namespace App\Helpers;

use Exception;

/**
 * Obtém dados das API ou do Cache
 */
class ApiHelper{
  private static $id, $page, $loja;
  
  /**
   * Pega os dados nescessários da API da Lomadee
   * @return string JSON 
   */
  private static function getAPI(): string{
    $dados = ['sourceId' => $_ENV['SOURCE_ID_LOMADEE']];
    if (self::$loja!==0){$dados['storeId'] = self::$loja;}
    if (self::$id===999){
      $dados['page'] = self::$page;
      $url = $_ENV['API_URL_LOMADEE'].'/v3/'.$_ENV['APP_TOKEN_LOMADEE'].'/offer/_store/'.self::$loja.'?'.http_build_query($dados);
    }elseif (self::$id!==0) {
      $dados['page'] = self::$page;
      $url = $_ENV['API_URL_LOMADEE'].'/v3/'.$_ENV['APP_TOKEN_LOMADEE'].'/offer/_category/'.self::$id.'?'.http_build_query($dados);
    }else {
      $url = $_ENV['API_URL_LOMADEE'].'/v2/'.$_ENV['APP_TOKEN_LOMADEE'].'/coupon/_all?'.http_build_query($dados);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (empty($json) || $status !== 200) {
      throw new Exception('Parece que tivemos um probleminha, que tal tentar de novo ?');
    }
    return $json;
  }
  
  /**
   * Verifica se as promoções salvas no cache ainda estão adequadas para uso, se sim, as usa, se não pega da API
   * @params integer $id $page $loja
   * @return array
   */
  public static function getPromo(int $id, int $page=1, int $loja=0): array{
    $path = __DIR__.'/../../resources/cache/';
    $path .= ($id!==999)?$id.'_'.$page.'.json':$loja.'_'.$page.'.json';
   
    if ($id===0 || file_exists($path)) {
      if ($id === 0 && !file_exists($path)) {
        file_put_contents($path, '[]');
        return [];
      }elseif ($id===0 || time()-filemtime($path)<1800) {
        return json_decode(file_get_contents($path), true);
      }
    }
    
    self::$id = $id;
    self::$page = $page;
    self::$loja = $loja;
    $json = self::getAPI();
    file_put_contents($path, $json);
    return json_decode($json, true);
  }
  
  /*
   * Pega os cupons da api do Awin em CVS e converte para array
   * return array
   */
  private static function getAwin(): array{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_ENV['API_URL_CSV_AWIN']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $csv = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (empty($csv) || $status !== 200) {
      throw new Exception('Parece que tivemos um probleminha, que tal tentar de novo ?');
    }
    $dado = array_map('str_getcsv', explode("\n", $csv));
    $a=1;
    for ($i=0; !empty($dado[$i][1]); $i++) {
      if ($dado[$i][1] === 'Aliexpress BR & LATAM'){
        $text = str_replace('Para todos os compradores', '', $dado[$i][5]);
        $text = str_replace('•', '', $dado[$i][5]);
        $cupom[$a-1]['code'] = $dado[$i][4];
        $cupom[$a-1]['vigency'] = $dado[$i][7];
        $cupom[$a-1]['description'] = $text;
        $cupom[$a-1]['link'] = $dado[$i][11];
        $cupom[$a-1]['store']['image'] = 'https://ae01.alicdn.com/kf/H2111329c7f0e475aac3930a727edf058z.png';
        $cupom[$a-1]['store']['name'] = 'Aliexpress';
        $a++;
      }elseif ($dado[$i][1] === 'Casas Bahia BR'){
        $cupom[$a-1]['code'] = $dado[$i][4];
        $cupom[$a-1]['vigency'] = $dado[$i][7];
        $cupom[$a-1]['description'] = $dado[$i][5];
        $cupom[$a-1]['link'] = $dado[$i][11];
        $cupom[$a-1]['store']['image'] = 'https://m.casasbahia.com.br/assets/images/casasbahia-logo-new.svg';
        $cupom[$a-1]['store']['name'] = 'Casas Bahia';
        $a++;
      }elseif ($dado[$i][1] === 'Extra BR') {
        $cupom[$a-1]['code'] = $dado[$i][4];
        $cupom[$a-1]['vigency'] = $dado[$i][7];
        $cupom[$a-1]['description'] = $dado[$i][5];
        $cupom[$a-1]['link'] = $dado[$i][11];
        $cupom[$a-1]['store']['image'] = 'https://m.extra.com.br/assets/images/ic-extra-navbar.svg';
        $cupom[$a-1]['store']['name'] = 'Extra';
        $a++;
      }elseif ($dado[$i][1] === 'Ponto BR') {
        $cupom[$a-1]['code'] = $dado[$i][4];
        $cupom[$a-1]['vigency'] = $dado[$i][7];
        $cupom[$a-1]['description'] = $dado[$i][5];
        $cupom[$a-1]['link'] = $dado[$i][11];
        $cupom[$a-1]['store']['image'] = 'https://m.pontofrio.com.br/assets/images/ic-navbar-logo.svg';
        $cupom[$a-1]['store']['name'] = 'Ponto';
        $a++;
      }
    }
    
    return $cupom;
  }
  
  /**
    * Verifica se os cupons salvos no servidor ainda estão adequados para uso, se sim, os usa, se não pega da API
   * @return array
   */
  public static function getCupons(): array{
    $path = __DIR__.'/../../resources/cache/cupons.json';
    $cached = false;
    if (file_exists($path)) {
      if(time()-filemtime($path)<86400){
        $cached=true;
      }
    }
    
    if ($cached) {
      $cupons = json_decode(file_get_contents($path), true);
    } else {
      self::$id = 0;
      $lomadee = json_decode(self::getAPI(), true);
      $awin = self::getAwin();
      $cupons = array_merge_recursive($awin, $lomadee['coupons']);
      file_put_contents($path, json_encode($cupons));
    }
    
    return $cupons;
  }
  
  /**
   * Faz a pesquisa nas ofertas usando a API do Lomadee
   * @param string $q
   * @param integer $page
   * @return array
   */
  public static function search(string $q, int $page): array{
    $dados = [
      'keyword' => $q,
      'sourceId' => $_ENV['SOURCE_ID_LOMADEE'],
      'page' => $page];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_ENV['API_URL_LOMADEE'].'/v3/'.$_ENV['APP_TOKEN_LOMADEE'].'/offer/_search?'.http_build_query($dados));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (empty($json) || $status !== 200) {
      throw new Exception('Parece que tivemos um probleminha, que tal tentar de novo, escrevendo de outra forma ?');
    }
    return json_decode($json, true);
  }
}