<?php

namespace App\Helpers;

class CsvHelper{
  /**
   * Faz a leitura de arquivos CSV
   * @param string $arquivo
   * @param bool $cabecalho
   * @param string $delimitador
   * @return array
   */
  public static function readCSV(string $arquivo, bool $cabecalho = true, string $delimitador = ','): array{
    if (file_exists($arquivo) || strpos($arquivo, 'https://')==0){
      $dados = [];
      $csv = fopen($arquivo, 'r');
      while ($linha = fgetcsv($csv, 0, $delimitador)){
        if ($cabecalho): $cabecalho = false; continue; endif;
        $dados[] = $linha;
      }
      return $dados;
    }
    return [];
  }
}
