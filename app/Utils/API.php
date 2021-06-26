<?php
namespace Promos\Utils;

use \Exception;

/**
 * Faz consultas nas APIs e retorna arrays com o resultado
 */
class API{
  const SOURCE_ID = '{soucer-id-lomadee}';
  const API_URL = 'http://api.lomadee.com';
  const APP_TOKEN = '{app-token-lomadee}';
  
  /*
   * Pega os cupons da api do Awin em CVS e converte para JSON
   * return string JSON
   */
  private static function getAwin(){
    $dado = array_map('str_getcsv', file('{link-da-api-Awin-csv}'));
    $a=1;
    for ($i=0; !empty($dado[$i]); $i++) {
      if ($dado[$i][1] === 'Aliexpress BR & LATAM'){
        $text = str_replace('Para todos os compradores', '', $dado[$i][5]);
        $cupom[$a-1]['code'] = $dado[$i][4];
        $cupom[$a-1]['vigency'] = $dado[$i][7];
        $cupom[$a-1]['description'] = $text;
        $cupom[$a-1]['link'] = $dado[$i][11];
        $cupom[$a-1]['store']['image'] = 'https://ae01.alicdn.com/kf/H2111329c7f0e475aac3930a727edf058z.png';
        $cupom[$a-1]['store']['name'] = 'Aliexpress';
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
    $dados = ['sourceId' => self::SOURCE_ID];
    if ($loja!==0){$dados['storeId'] = $loja;}
    if ($id===999){
      $dados['page'] = $page;
      $json = file_get_contents(self::API_URL.'/v3/'.self::APP_TOKEN.'/offer/_store/'.$loja.'?'.http_build_query($dados));
    }elseif ($id!==0) {
      $dados['page'] = $page;
      $json = file_get_contents(self::API_URL.'/v3/'.self::APP_TOKEN.'/offer/_category/'.$id.'?'.http_build_query($dados));
    }else {
      $json = file_get_contents(self::API_URL.'/v2/'.self::APP_TOKEN.'/coupon/_all?'.http_build_query($dados));
    }
    if (empty($json)) {
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
      'sourceId' => self::SOURCE_ID,
      'page' => $page];
    return json_decode(file_get_contents(self::API_URL.'/v3/'.self::APP_TOKEN.'/offer/_search?'.http_build_query($dados)), true);
  }
}