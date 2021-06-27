<?php

namespace Promos\Controller\Api;

/**
 * Gere as páginas da Api
 */
class Api{
  
  /**
   * Faz as devidas verificações para autenticar o usuário
   * @return boolean
   */
  public static function auth(){
    $dados = base64_decode(str_ireplace('Basic ', '', $_SERVER['HTTP_AUAUTHORIZATION']??''));
    $dados = explode(':', $dados, 2);
    if ($dados[0] === '{user-admin}' && password_verify($dados[1], 'password-admin-em-password-hash') {
      return true;
    }
    return false;
  }
}
