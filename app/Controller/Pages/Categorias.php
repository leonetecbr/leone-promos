<?php
namespace Promos\Controller\Pages;

use \Promos\Utils;
use \Exception;

/**
 * Processa todas as páginas de categoria
 */
class Categorias extends Page{
  
  /**
   * Gera a página com a lista das categorias
   * @return string
   */
  public static function get(){
    $content = Utils\View::render('pages/categorias');
      
    return Page::getPage('Categorias', $content);
  }
  
  /*
   * Processa as páginas das categorias
   * @param string $categoria
   * @param integer $page
   * @return string
   */
  public static function process($categoria, $page){
    try{
      $page = ($page===0)?1:$page;
      switch ($categoria) {
        case 'smartphones':
          $dados['id'] = 77;
          $dados['title'] = 'Smartphones';
          break;
        
        case 'informatica':
          $dados['id'] = 2;
          $dados['title'] = 'Informática';
          break;
        
        case 'eletronicos':
          $dados['id'] = 1;
          $dados['title'] = 'Eletrônicos';
          break;
        
        case 'eletrodomesticos':
          $dados['id'] = 116;
          $dados['title'] = 'Eletrodomésticos';
          break;
        
        case 'pc':
          $dados['id'] = 22;
          $dados['title'] = 'PCs';
          break;
        
        case 'bonecas':
          $dados['id'] = 194;
          $dados['title'] = 'Bonecas';
          break;
        
        case 'tv':
          $dados['id'] = 2852;
          $dados['title'] = 'TVs';
          break;
        
        case 'fogao':
          $dados['id'] = 138;
          $dados['title'] = 'Fogão';
          break;
        
        case 'geladeira':
          $dados['id'] = 3673;
          $dados['title'] = 'Geladeira';
          break;
        
        case 'lavaroupas':
          $dados['id'] = 3671;
          $dados['title'] = 'Máquina de Lavar Roupas';
          break;
        
        case 'roupasm':
          $dados['id'] = 7690;
          $dados['title'] = 'Roupas Masculinas';
          break;
        
        case 'roupasf':
          $dados['id'] = 7691;
          $dados['title'] = 'Roupas Femininas';
          break;
        
        case 'talheres':
          $dados['id'] = 2735;
          $dados['title'] = 'Talheres';
          break;
        
        case 'camas':
          $dados['id'] = 2712;
          $dados['title'] = 'Camas';
          break;
        
        case 'casaedeco':
          $dados['id'] = 2701;
          $dados['title'] = 'Casa e decoração';
          break;
        
        case 'armario':
          $dados['id'] = 2801;
          $dados['title'] = 'Guarda-roupa';
          break;
        
        case 'mesas':
          $dados['id'] = 2916;
          $dados['title'] = 'Mesas';
          break;
        
        case 'luz':
          $dados['id'] = 2930;
          $dados['title'] = 'Lâmpada';
          break;
        
        default:
          throw new Exception('Categoria não encontrada!');
          break;
      }
      $dado = Utils\API::getPromo($dados['id'], $page);
      $ofertas = $dado['offers'];
      $pages = $dado['pagination']['totalPage'];
      $text = Utils\Promotions::getPromos($ofertas, $dados['id'], $page);
      $pagination = Utils\Promotions::getPages($page, $pages);
    }catch (Exception $e){
      $dados['title'] = 'Não encontrada';
      $text = '<p class="fs-12 erro">'.$e->getMessage().'</p>';
    } finally{
      $content = Utils\View::render('pages/promos',[
        'title' => $dados['title'],
        'page' => $pagination??'',
        'promo' => $text
      ]);
      return Page::getPage('Categoria: '.$dados['title'].' - Página '.$page, $content);
    }
  }
}
