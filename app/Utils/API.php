<?php
namespace Leone\Promos\Utils;

use \Exception;

/**
 * Faz consultas nas APIs e retorna arrays com o resultado
 */
class API{
  
  /*
   * Pega os cupons da api do Awin em CVS e converte para JSON
   * return string JSON
   */
  private static function getAwin(){
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
    
    return json_encode($cupom, JSON_UNESCAPED_UNICODE);
  }
  
  
  /**
   * Pega os dados nescessários da API da Lomadee
   * @params integer $id $page $loja
   * @return string JSON 
   */
  private static function getAPI($id, $page=1, $loja=0){
    $dados = ['sourceId' => $_ENV['SOURCE_ID_LOMADEE']];
    if ($loja!==0){$dados['storeId'] = $loja;}
    if ($id===999){
      $dados['page'] = $page;
      $url = $_ENV['API_URL_LOMADEE'].'/v3/'.$_ENV['APP_TOKEN_LOMADEE'].'/offer/_store/'.$loja.'?'.http_build_query($dados);
    }elseif ($id!==0) {
      $dados['page'] = $page;
      $url = $_ENV['API_URL_LOMADEE'].'/v3/'.$_ENV['APP_TOKEN_LOMADEE'].'/offer/_category/'.$id.'?'.http_build_query($dados);
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
   * Verifica se as promoções salvas no servidor ainda estão adequados para uso, se sim, os usa, se não pega da API
   * @params integer $id $page $loja
   * @return array
   */
  public static function getPromo($id, $page=1, $loja=0){
    $path = ($id!==999)?__DIR__.'/../../resources/cache/promos/'.$id.'_'.$page.'.json':__DIR__.'/../../resources/cache/lojas/'.$loja.'_'.$page.'.json';
   
    if ($id===0 || file_exists($path)) {
      if ($id===0 || time()-filemtime($path)<1800) {
        return json_decode(file_get_contents($path), true);
      }
    }
    
    $json = self::getAPI($id, $page, $loja);
    file_put_contents($path, $json);
    return json_decode($json, true);
  }
  
  /**
    * Verifica se os cupons salvos no servidor ainda estão adequados para uso, se sim, os usa, se não pega da API
   * @params integer $page
   * @return array
   */
  public static function getCupons(){
    $path[0] = __DIR__.'/../../resources/cache/cupons/awin.json';
    $path[1] = __DIR__.'/../../resources/cache/cupons/lomadee.json';
    $path['success'][0] = false;
    $path['success'][1] = false;
    if (file_exists($path[0])) {
      if(time()-filemtime($path[0])>86400){
        $json = self::getAwin();
        file_put_contents($path[0], $json);
        $cupom[0] = json_decode($json, true);
        $path['success'][0]=true;
      }
    }else {
      $json = self::getAwin();
      file_put_contents($path[0], $json);
      $cupom[0] = json_decode($json, true);
      $path['success'][0]=true;
    }
    
    if (file_exists($path[1])) {
      if (time()-filemtime($path[1])>86400) {
        $json = self::getAPI(0);
        file_put_contents($path[1], $json);
        $cupom[1] = json_decode($json, true);
        $path['success'][1]=true;
      }
    }else {
      $json = self::getAPI(0);
      file_put_contents($path[1], $json);
      $cupom[1] = json_decode($json, true);
      $path['success'][1]=true;
    }
    
    if (!$path['success'][0]) {
      $cupom[0] = json_decode(file_get_contents($path[0]), true);
    }
    
    if (!$path['success'][1]) {
      $cupom[1] = json_decode(file_get_contents($path[1]), true);
      $cupom[1] = $cupom[1]['coupons'];
    }
    
    return array_merge_recursive($cupom[0], $cupom[1]);
  }
  
  /**
   * Faz a pesquisa nas ofertas usando a API do Lomadee
   * @param string $q
   * @return array
   */
  public static function search($q, $page){
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