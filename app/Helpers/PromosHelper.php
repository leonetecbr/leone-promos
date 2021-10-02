<?php
namespace App\Helpers;

/**
 * Gera itens relacionados as promoções
 */
class PromosHelper{
  
  /*
   * Gera os botões para paginação
   * @params integer $atual $final
   * @return string
   */
  public static function getPages(int $atual, int $final): string{
    
    if (stripos($_SERVER['REQUEST_URI'], '/search') === 0){
      $class = ' pages';
    }else{
      $class = '';
    }
    
    $to = str_replace('/'.$atual, '', $_SERVER['REQUEST_URI']).'/';
    if ($atual!==1){
      $ant = $atual-1;
      $p1 = "<a href='{$to}1' class='left$class'><i class='fas fa-angle-double-left'></i></a>
      <a href='$to$ant' class='left$class'><i class='fas fa-angle-left'></i></a>";
    }else{$p1='';}
    
    $pages = '<h3 class="container">Página '.$atual.' de '.$final.'</h3>
<div class="container center" id="pagination">'.$p1;
    if ($final>3) {
      $pro = $atual+1;
      if ($atual<=1) {
        $pages .= " <a href='#' class='atual-page'>1</a>
      <a href='{$to}2' class='bg-gradiente$class'>2</a>
      <a href='{$to}3' class='bg-gradiente$class'>3</a>";
      }elseif ($atual==$final) {
        if ($atual>=3) {
          $pages .= '<span class="bolder">...</span>';
        }
        $antt = $ant-1;
        $pages .= "<a href='$to$antt' class='bg-gradiente$class'>$antt</a>
        <a href='$to$ant 'class='bg-gradiente$class'>$ant</a>
        <a href='#' class='atual-page'>$atual</a>";
        }else{
          if ($atual>=3) {
            $pages .= '<span class="bolder">...</span>';
          }
          $pages .= " <a href='$to$ant 'class='bg-gradiente$class'>$ant</a>
          <a href='#' class='atual-page'>{$atual}</a>
          <a href='$to$pro' class='bg-gradiente$class'>$pro</a>";
        }
        if (!($pro+1>$final)) {
          $pages .= '<span class="bolder">...</span>';
        }
    }else{
      for ($i=1;$i<=$final; $i++) {
        if($i==$atual){
          $a='atual-page';
          $l='#';
        }else{
          $a='bg-gradiente pages';
          $l="$to$i";
        }
        $pages .= "<a href='$l' class='$a'>$i</a>";
      }
    }
    if (!($atual+1>$final)){
      $pro = $atual+1;
      $pages .= "<a href='$to$final' class='right$class'><i class='fas fa-angle-double-right'></i></a><a href='$to$pro' class='right$class'><i class='fas fa-angle-right'></i></a>";
    }
    $pages .= '</div>';
    return $pages;
  }
}