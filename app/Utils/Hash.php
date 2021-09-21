<?php
namespace Leone\Promos\Utils;

/**
 * Classe responsável por gerar strings aleatórias
 */
class Hash{
  
  /**
   * Método responsável por retornar uma string aleatória de tamanho padrão 32
   * @param integer $size
   * @return string
   */
  public static function generateHash(int $size = 32): string{
    $chars = "ABCDEFabcdef0123456789";
    $randomString = '';
    for($i=0;$i<$size;$i++){
     $randomString .= $chars[mt_rand(0,21)];
    }
    return $randomString;
  }
  
}