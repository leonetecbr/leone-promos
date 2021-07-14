<?php
namespace Leone\Promos\Utils;

/**
 * Verifica se é usuário mobile
 */
class Mobile{
  
  public static function isOrNot(){
    $mobile = false;
    $user_agents = ["iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric"];
    foreach($user_agents as $user_agent){
      if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
          $mobile = true;
          break;
      }
    }
    return $mobile;
  }
}