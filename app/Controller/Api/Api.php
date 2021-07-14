<?php

namespace Leone\Promos\Controller\Api;

/**
 * Gere as páginas da Api
 */
class Api{
  
  /**
   * Faz as devidas verificações para autenticar o usuário
   * @return boolean
   */
  public static function auth(){
    if (!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])) {
      $dados = [$_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']];
    }elseif (!empty($_SERVER['HTTP_AUAUTHORIZATION'])) {
      $dados = base64_decode(str_ireplace('Basic ', '', $_SERVER['HTTP_AUAUTHORIZATION']));
      $dados = explode(':', $dados, 2);
    }else{
      return false;
    }
    
    return ($dados[0] === $_ENV['USER_API'] && password_verify($dados[1], $_ENV['PASS_API']));
  }
}
