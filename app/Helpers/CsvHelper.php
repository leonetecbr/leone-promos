<?php

namespace App\Helpers;

class CsvHelper
{
    /**
     * Faz a leitura de arquivos CSV
     */
    public static function readCSV(string $filename, bool $header = true, string $delimiter = ','): array
    {
        if (file_exists($filename) || str_starts_with($filename, 'https://')) {
            $dados = [];
            $csv = fopen($filename, 'r');
            while ($linha = fgetcsv($csv, 0, $delimiter)) {
                if ($header) : $header = false;
                    continue;
                endif;
                $dados[] = $linha;
            }
            return $dados;
        }
        return [];
    }
}
