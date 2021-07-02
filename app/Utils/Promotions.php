<?php
namespace Promos\Utils;

use \Exception;
/**
 * Transforma as promoções e cupons de arrays em HTML
 */
class Promotions{
  
  /* 
   * Passa URLs de compartilhamento a depender do tipo do dispositivo do usuário
   * @return array $share
   */
  private static function getShareParams(){
    $mobile = Mobile::isOrNot();
    if ($mobile) {
      $share['w'] = 'whatsapp://send?text=';
      $share['m'] = 'fb-messenger://share?app_id=2988320711410858&link=';
      $share['t'] = 'tg://msg_url?text=';
    }else {
      $share['w'] = 'https://api.whatsapp.com/send?text=';
      $share['m'] = 'https://www.facebook.com/dialog/send?redirect_uri=https%3A%2F%2Fofertas.leone.tec.br&app_id=2988320711410858&link=';
      $share['t'] = 'https://t.me/share/url?text=';
    }
    $share['u'] = "https://para.promo/";
    return $share;
  }
  
  /**
   * Transforma o array de ofertas em conteúdo legível
   * @param array $ofertas
   * @params integer $cat_id $page
   * @return string
   */
  public static function getPromos($ofertas, $cat_id, $page=1){
    try {
      if (empty($ofertas)) {
        throw new Exception('Nenhuma oferta encontrada!');
      }
      $content = '<main id="promos" class="container center">
      <div id="noeye"></div>';
      $share = self::getShareParams();
      for ($i=0; !empty($ofertas[$i]); $i++) {
        if (!empty($ofertas[$i]['description'])){
          $d['w'] = '%0A%0A'.$ofertas[$i]['description_text'];
          $d['j'] = str_ireplace('&apos;', '', $ofertas[$i]['description_text']);
          $d['j'] = str_ireplace("\n", '  ', $d['j']);
        }else{
          $d['w'] = '';
          $d['j'] = '';
        }
        
        $from = ($ofertas[$i]['discount']>=0.01)?'<p>De: <del>R$ '.number_format($ofertas[$i]['priceFrom'], 2, ',', '.').'</del></p>':'';
        
        if (!empty($ofertas[$i]['installment'])){
          if (($ofertas[$i]['installment']['quantity']*$ofertas[$i]['installment']['value']) <= $ofertas[$i]['price']+0.05) {
            $sj = ' sem juros';
          }else{$sj = '';}
          $parcelas = '<p>'.$ofertas[$i]['installment']['quantity'].'x'.$sj.' de R$ '.number_format($ofertas[$i]['installment']['value'], 2, ',', '.').'</p>';
        }else{
          $parcelas = '<p>Apenas à vista!</p>';
        }
        
        $btn = empty($ofertas[$i]['code'])?'
          <a target="_blank" href="'.$ofertas[$i]['link'].'"><button class="bg-black radius">
            Ir para a loja
          </button></a>':'<button onclick="copy('."'{$ofertas[$i]['link']}', '#input{$i}')".'" class="bg-black radius">Copiar e ir para a loja</button>';
        
        $code = empty($ofertas[$i]['code'])?'':'<p class="code">Cupom: <input value="'.$ofertas[$i]['code'].'" disabled="true" class="center" id="input'.$i.'"/></p>';
        
        $desc = empty($ofertas[$i]['description'])?'':'<p>'.$ofertas[$i]['description'].'</p>';
        
        $content .= '<article class="promo bg-white" id="'.$cat_id.'_'.$page.'_'.$i.'">
          <div class="share">
           <p><a href="'.$share['w'].urlencode($ofertas[$i]['name']).'%0A%0A'.urlencode('*Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.').'*').$d['w'].'%0A%0A'.urlencode($share['u']).'o%2F'.$cat_id.'_'.$page.'_'.$i.'" class="wpp" target="blank"><i class="fab fa-whatsapp"></i></a>
           <a href="'.$share['t'].'%0A'.urlencode($ofertas[$i]['name']).'%0A%0A'.urlencode('**Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.')).'**'.$d['w'].'&url='.urlencode($share['u']).'o%2F'.$cat_id.'_'.$page.'_'.$i.'" class="tlg" target="blank"><i class="fab fa-telegram-plane"></i></a>
            <a href="'.$share['m'].urlencode($share['u']).'o%2F'.$cat_id.'_'.$page.'_'.$i.'" class="fbm" target="blank"><i class="fab fa-facebook-messenger"></i></a>
            <a href="http://twitter.com/share?text='.urlencode($ofertas[$i]['name']).'%0A%0A'.urlencode('Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.')).$d['w'].'%0A%0A'.'&url='.urlencode($share['u']).'o%2F'.$cat_id.'_'.$page.'_'.$i.'" class="twt" target="blank"><i class="fab fa-twitter"></i></a>
            <a href="#" class="pls plus-share" onclick="event.preventDefault();copy_s('."'".$ofertas[$i]['name'].' '.$d['j'].'  Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.').' '.$share['u']."o/{$cat_id}_{$page}_{$i}'".');"><i class="fas fa-copy"></i></a>
            <a href="#" class="pls hidden plus-share" onclick="event.preventDefault();navigator.share({title: '."'{$ofertas[$i]['name']}', text: '{$ofertas[$i]['name']}".'\n\n'."Por apenas: R$ ".number_format($ofertas[$i]['price'], 2, ',', '.').'\n'."', url: '{$share['u']}o/{$cat_id}_{$page}_{$i}'});".'"><i class="fas fa-share-alt"></i></a></p>
            </div>
        <img src="'.$ofertas[$i]['thumbnail'].'" alt="'.$ofertas[$i]['name'].'"/>
        <div class="inner">
          <a target="_blank" href="'.$ofertas[$i]['link'].'">'. mb_strimwidth($ofertas[$i]['name'], 0, 50, '...' ).'</a>'.$from.'<h4>R$ '.number_format($ofertas[$i]['price'], 2, ',', '.').'</h4>
          '.$parcelas.$desc.$code."\n".'
          <div class="loja"><a target="_blank" href="'.$ofertas[$i]['store']['link'].'"><img src="'. $ofertas[$i]['store']['thumbnail'].'" alt="'.$ofertas[$i]['store']['name'].'"></a></div>'."\n".$btn.'
        </div>
      </article>';
      }
      $content .= '<div class="right fs-12 bolder"><button class="padding bg-orange" onclick="'."$('html, body').animate({scrollTop : 0},800);".'"><i class="fas fa-angle-double-up text-white"></i></button><p>
      Topo</p>
      </div></main>';
    } catch (Exception $e) {
      $content = $e->getMessage();
    } finally{
      return $content;
    }
  }
  
  /*
   * Gera os botões para paginação
   * @params integer $atual $final
   * @return string
   */
  public static function getPages($atual, $final){
    
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
  
  /**
   * Transforma o array de cupons em um conteúdo legível 
   * @param array $cupons
   * @return string
   */
  public static function getCupons($cupom, $page){
    try{
      $content = '<main id="cupons" class="container center">
      <div id="noeye"></div>';
      $share = self::getShareParams();
      
      $i = (intval($page)-1)*18;
      $imax = intval($page)*18-1;
      for ($i; !empty($cupom[$i]) && $i<=$imax; $i++) {
        $content .= '<article class="cupom bg-white radius" id="cupom_'.$i.'">
  <div class="share">
       <p><a href="'.$share['w'].urlencode($cupom[$i]['description']).'%0A%0A'.urlencode('*Cupom:* ```'.$cupom[$i]['code'].'```').'%0A%0A*Link:* '.urlencode($share['u'])."c%2F$i".'" class="wpp" target="blank"><i class="fab fa-whatsapp"></i></a>
        <a href="'.$share['t'].'%0A'.urlencode($cupom[$i]['description']).'%0A%0A'.urlencode('**Cupom:** `'.$cupom[$i]['code'].'`').'&url='.urlencode($share['u'])."c%2F$i".'" class="tlg" target="blank"><i class="fab fa-telegram-plane"></i></a>
        <a href="'.$share['m'].urlencode($share['u'])."c%2F$i".'" class="fbm" target="blank"><i class="fab fa-facebook-messenger"></i></a>
        <a href="http://twitter.com/share?text='.urlencode($cupom[$i]['description']).'%0A%0A'.urlencode('Cupom: '.$cupom[$i]['code'].'').'%0A'.'&url='.urlencode($share['u'])."c%2F$i".'" class="twt" target="blank"><i class="fab fa-twitter"></i></a>
        <a href="#" class="pls plus-share" onclick="event.preventDefault();copy_s('."'".$cupom[$i]['description'].'  Cupom: '.$cupom[$i]['code'].' Link: '.$share['u']."c/$i')".'"><i class="fas fa-copy"></i></a>
        <a href="#" class="pls hidden plus-share" onclick="event.preventDefault();navigator.share({title: '."'".$cupom[$i]['description']."'".', text: '."'".$cupom[$i]['description'].'\n\nCupom: '.$cupom[$i]['code'].'\n'."'".', url: '."'".$share['u']."c/$i'".'});"><i class="fas fa-share-alt"></i></a>
        </p>
        <div class="site"><img src="'.$cupom[$i]['store']['image'].'" alt="'.$cupom[$i]['store']['name'].'"></div>
        <h4>'.mb_strimwidth($cupom[$i]['description'], 0, 100, '...' ).'</h4>
        <p>Válido até '.str_replace(":59:00", ":59:59", $cupom[$i]['vigency']).'</p>
<p class="code">Cupom: <input value="'.$cupom[$i]['code'].'" disabled="true" class="center" id="input_'.$i.'"/></p>
<button onclick="copy('."'".$cupom[$i]['link']."', '#input_".$i."')".'" class="bg-black radius">
  Copiar e ir para a loja
</button>
        </div>
      </article>';
      }
    
      $content .= '<div class="right fs-12 bolder"><button class="padding bg-orange" onclick="'."$('html, body').animate({scrollTop : 0},800);".'"><i class="fas fa-angle-double-up text-white"></i></button><p>
      Topo</p>
      </div></main>';
    }catch (Exception $e) {
      $content = $e->getMessage();
    } finally{
      return $content;
    }
  }
}
