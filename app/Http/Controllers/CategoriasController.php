<?php

namespace App\Http\Controllers;

use App\Helpers;
use Exception;

class CategoriasController extends Controller
{

  /*
   * Retorna a lista com as principais categorias
   */
  public static function get()
  {
    return view('categorias');
  }

  /*
   * Encontra o código corresponde a categoria através do nome para poder buscar os dados corretos no banco de dados
   * @param string $categoria
   * @param int $page
   */
  public static function process(string $categoria, int $page = 1)
  {
    try {
      switch ($categoria) {
        case 'smartphones':
          $id = 77;
          $title = 'Smartphones';
          break;

        case 'informatica':
          $id = 2;
          $title = 'Informática';
          break;

        case 'eletronicos':
          $id = 1;
          $title = 'Eletrônicos';
          break;

        case 'eletrodomesticos':
          $id = 116;
          $title = 'Eletrodomésticos';
          break;

        case 'pc':
          $id = 22;
          $title = 'PCs';
          break;

        case 'bonecas':
          $id = 194;
          $title = 'Bonecas';
          break;

        case 'tv':
          $id = 2852;
          $title = 'TVs';
          break;

        case 'fogao':
          $id = 138;
          $title = 'Fogão';
          break;

        case 'geladeira':
          $id = 3673;
          $title = 'Geladeira';
          break;

        case 'lavaroupas':
          $id = 3671;
          $title = 'Máquina de Lavar Roupas';
          break;

        case 'roupasm':
          $id = 7690;
          $title = 'Roupas Masculinas';
          break;

        case 'roupasf':
          $id = 7691;
          $title = 'Roupas Femininas';
          break;

        case 'talheres':
          $id = 2735;
          $title = 'Talheres';
          break;

        case 'camas':
          $id = 2712;
          $title = 'Camas';
          break;

        case 'casaedeco':
          $id = 2701;
          $title = 'Casa e decoração';
          break;

        case 'mesas':
          $id = 2916;
          $title = 'Mesas';
          break;

        default:
          throw new Exception('Categoria não encontrada!');
          break;
      }
      $dado = Helpers\ApiHelper::getPromo($id, $page);
      $ofertas = $dado['offers'];
      $pages = $dado['totalPage'];
      $subtitle = $title;
      $title = 'Categoria: ' . $title . " - Página {$page} de {$pages}";
    } catch (Exception $e) {
      $title = 'Não encontrada';
      $ofertas = '<p class="fs-4 text-danger error mt-3 mx-auto">' . $e->getMessage() . '</p>';
      $topo = false;
    }

    return view('promos', ['title' => $title, 'subtitle' => $subtitle ?? $title, 'promos' => $ofertas, 'cat_id' => $id ?? 0, 'page' => $page, 'final' => $pages ?? '', 'topo' => $topo ?? true, 'isLoja' => false, 'group_name' => $categoria ?? '']);
  }
}
