<?php
namespace Leone\Promos\Utils;

/**
 * Transforma as promoções e cupons de arrays em HTML
 */
class Promotions{
  
  /* 
   * Passa URLs de compartilhamento a depender do tipo do dispositivo do usuário
   * @return array $share
   */
  private static function getShareParams(): array{
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
   * Gera o link curto para compartilhamento nas redes sociais
   * @param string $url
   * @return string
   */
  private static function getShortLink(string $url): string{
    if (preg_match('/amazon\.com\.br\/.+\/dp\/(\w+)/', $url, $product_id) || preg_match('/amazon\.com\.br\/gp\/product\/(\w+)/', $url, $product_id)) {
      $short = 'amazon/'.$product_id[1];
    }elseif (preg_match('/magazinevoce\.com\.br\/magazineofertasleone\/p\/(\w+)/', $url, $product_id) || preg_match('/magazinevoce\.com\.br\/magazineofertasleone\/.+\/p\/(\w+)/', $url, $product_id)){
      $short = 'magalu/'.$product_id[1];
    }elseif (preg_match('/americanas\.com\.br\/produto\/(\w+)/', $url, $product_id)){
      $short = 'americanas/'.$product_id[1];
    }elseif (preg_match('/submarino\.com\.br\/produto\/(\w+)/', $url, $product_id)){
      $short = 'submarino/'.$product_id[1];
    }elseif (preg_match('/shoptime\.com\.br\/produto\/(\w+)/', $url, $product_id)){
      $short = 'shoptime/'.$product_id[1];
    }elseif (preg_match('/pt\.aliexpress\.com\/item\/(\w+)\.html/', $url, $product_id)){
      $short = 'aliexpress/'.$product_id[1];
    }else{
      $short = '';
    }
    return 'https://para.promo/'.$short;
  }
  
  /**
   * Transforma o array de ofertas em conteúdo legível
   * @param array $ofertas
   * @params integer $cat_id $page
   * @return string
   */
  public static function getPromos(array $ofertas, int $cat_id, int $page=1): string{
    if (empty($ofertas)) {
      $content = '<p class="m-auto">Nenhuma oferta encontrada!</p></article>';
    }else{
      $content = '<div id="noeye"></div>';
      $share = self::getShareParams();
      for ($i=0; !empty($ofertas[$i]); $i++) {
        $ofertas[$i]['name'] = htmlspecialchars($ofertas[$i]['name'], ENT_QUOTES);
        if (!empty($ofertas[$i]['description'])){
          $patter = '/\<.+\>(.*)\<\/.+\>/';
          $description_text = preg_replace($patter, '$1', $ofertas[$i]['description']); 
          $d['w'] = '%0A%0A'.$description_text;
          $d['j'] = str_replace('&apos;', '', $description_text);
        }else{
          $d['w'] = '';
          $d['j'] = '';
        }
        
        $from = (!empty($ofertas[$i]['discount']) && $ofertas[$i]['discount']>=0.01)?'<p>De: <del>R$ '.number_format($ofertas[$i]['priceFrom'], 2, ',', '.').'</del></p>':'';
        
        if (!empty($ofertas[$i]['installment'])){
          if (($ofertas[$i]['installment']['quantity']*$ofertas[$i]['installment']['value']) <= $ofertas[$i]['price']+0.05) {
            $sj = ' sem juros';
          }else{$sj = '';}
          $parcelas = '<p class="installment">'.$ofertas[$i]['installment']['quantity'].'x'.$sj.' de R$ '.number_format($ofertas[$i]['installment']['value'], 2, ',', '.').'</p>';
        }else{
          $parcelas = '<p class="installment">Apenas à vista!</p>';
        }
        
        if ($cat_id===0) {
          $short_link = self::getShortLink($ofertas[$i]['link']);
          $short_link = ($short_link!='https://para.promo/')?$short_link:$short_link."o/{$cat_id}_{$page}_{$i}";
        }
        
        if (empty($short_link)){
          $short_link = "https://para.promo/o/{$cat_id}_{$page}_{$i}";
        }
        
        $btn = empty($ofertas[$i]['code'])?'
          <a target="_blank" href="'.$ofertas[$i]['link'].'"><button class="bg-black radius">
            Ir para a loja
          </button></a>':'<button onclick="copy('."'{$ofertas[$i]['link']}', '#input{$i}')".'" class="fs-12 btn bg-black radius">Copiar e ir para a loja</button>';
        
        $code = empty($ofertas[$i]['code'])?'':'<p class="code">Cupom: <input value="'.$ofertas[$i]['code'].'" disabled="true" class="center discount" id="input'.$i.'"/></p>';
        
        $desc = empty($ofertas[$i]['description'])?'':'<p class="description">'.$ofertas[$i]['description'].'</p>';
        
        $content .= '<div class="promo bg-white" id="'.$cat_id.'_'.$page.'_'.$i.'" data-short-link="'.$short_link.'">
          <div class="share">
           <p><a href="#story" class="igs"><i class="fab fa-instagram"></i></a>
           <a href="'.$share['w'].urlencode($ofertas[$i]['name']).'%0A%0A'.urlencode('*Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.').'*').$d['w'].'%0A%0A'.urlencode($short_link).'" class="wpp" target="_blank"><i class="fab fa-whatsapp"></i></a>
           <a href="'.$share['t'].'%0A'.urlencode($ofertas[$i]['name']).'%0A%0A'.urlencode('**Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.')).'**'.$d['w'].'&url='.urlencode($short_link).'" class="tlg" target="_blank"><i class="fab fa-telegram-plane"></i></a>
            <a href="'.$share['m'].urlencode($short_link).'" class="fbm" target="_blank"><i class="fab fa-facebook-messenger"></i></a>
            <a href="http://twitter.com/share?text='.urlencode($ofertas[$i]['name']).'%0A%0A'.urlencode('Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.')).$d['w'].'%0A%0A'.'&url='.urlencode($short_link).'" class="twt" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="#" class="pls plus-share" onclick="event.preventDefault();copy_s(\''.$ofertas[$i]['name'].' '.$d['j'].'  Por apenas: R$ '.number_format($ofertas[$i]['price'], 2, ',', '.').' '.$short_link.'\');"><i class="fas fa-copy"></i></a>
            <a href="#" class="pls hidden plus-share" onclick="event.preventDefault();navigator.share({title: '."'{$ofertas[$i]['name']}', text: '{$ofertas[$i]['name']}".'\n\n'."Por apenas: R$ ".number_format($ofertas[$i]['price'], 2, ',', '.').'\n'."', url: '{$short_link}'});".'"><i class="fas fa-share-alt"></i></a></p>
            </div>
        <div class="inner">
        <img src="'.$ofertas[$i]['thumbnail'].'" alt="'.$ofertas[$i]['name'].'" class="product-image"/><br/>
          <a target="_blank" href="'.$ofertas[$i]['link'].'" class="product-title">'. mb_strimwidth($ofertas[$i]['name'], 0, 50, '...' ).'</a>'.$from.'<h4>R$ '.number_format($ofertas[$i]['price'], 2, ',', '.').'</h4>
          '.$parcelas.$desc.$code."\n".'
        </div>
        <div class="final">
          <div class="loja"><a target="_blank" href="'.$ofertas[$i]['store']['link'].'"><img src="'. $ofertas[$i]['store']['thumbnail'].'" alt="'.$ofertas[$i]['store']['name'].'"></a></div>'."\n".$btn.'
        </div>
      </div>';
      }
      $content .= '</article>
      <div class="flex-column flex-center fs-12 bolder top"><button class="padding bg-orange" onclick="'."$('html, body').animate({scrollTop : 0},800);".'"><i class="fas fa-angle-double-up text-white"></i></button><p>
      Topo</p>
      </div>';
    }
    return '<article id="promos" class="container center">'.$content;
  }
  
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
  
  /**
   * Transforma o array de cupons em um conteúdo legível 
   * @param array $cupom
   * @param integer $page
   * @return string
   */
  public static function getCupons(array $cupom, int $page): string{
    try{
      $content = '<article id="cupons" class="container center">
      <div id="noeye"></div>';
      $share = self::getShareParams();
      
      $i = (intval($page)-1)*18;
      $imax = intval($page)*18-1;
      for ($i; !empty($cupom[$i]) && $i<=$imax; $i++) {
        $content .= '<div class="cupom bg-white radius" id="cupom_'.$i.'">
      <div class="share">
       <p><a href="'.$share['w'].urlencode($cupom[$i]['description']).'%0A%0A'.urlencode('*Cupom:* ```'.$cupom[$i]['code'].'```').'%0A%0A*Link:* '.urlencode($share['u'])."c%2F$i".'" class="wpp" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="'.$share['t'].'%0A'.urlencode($cupom[$i]['description']).'%0A%0A'.urlencode('**Cupom:** `'.$cupom[$i]['code'].'`').'&url='.urlencode($share['u'])."c%2F$i".'" class="tlg" target="_blank"><i class="fab fa-telegram-plane"></i></a>
        <a href="'.$share['m'].urlencode($share['u'])."c%2F$i".'" class="fbm" target="_blank"><i class="fab fa-facebook-messenger"></i></a>
        <a href="http://twitter.com/share?text='.urlencode($cupom[$i]['description']).'%0A%0A'.urlencode('Cupom: '.$cupom[$i]['code'].'').'%0A'.'&url='.urlencode($share['u'])."c%2F$i".'" class="twt" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="#" class="pls plus-share" onclick="event.preventDefault();copy_s(\''.$cupom[$i]['description'].'  Cupom: '.$cupom[$i]['code'].' Link: '.$share['u']."c/$i')".'"><i class="fas fa-copy"></i></a>
        <a href="#" class="pls hidden plus-share" onclick="event.preventDefault();navigator.share({title: \''.$cupom[$i]['description'].'\', text: \''.$cupom[$i]['description'].'\n\nCupom: '.$cupom[$i]['code'].'\n\''.', url: \''.$share['u']."c/$i'".'});"><i class="fas fa-share-alt"></i></a>
        </p>
        </div>
        <div class="inner">
          <div class="site"><img src="'.$cupom[$i]['store']['image'].'" alt="'.$cupom[$i]['store']['name'].'"></div>
          <h4>'.mb_strimwidth($cupom[$i]['description'], 0, 100, '...' ).'</h4>
          <p>Válido até '.str_replace(":59:00", ":59:59", $cupom[$i]['vigency']).'</p>
          <p class="code">Cupom: <input value="'.$cupom[$i]['code'].'" disabled="true" class="center" id="input_'.$i.'"/></p>
          </div>
          <div class="final">
            <button onclick="copy(\''.$cupom[$i]['link']."', '#input_".$i."')".'" class="bg-black radius">
              Copiar e ir para a loja</button>
          </div>
      </div>';
      }
    
      $content .= '</article>
      <div class="flex-column flex-center fs-12 bolder top"><button class="padding bg-orange" onclick="'."$('html, body').animate({scrollTop : 0},800);".'"><i class="fas fa-angle-double-up text-white"></i></button><p>
      Topo</p>
      </div>';
    }catch (Exception $e) {
      $content = $e->getMessage();
    } finally{
      return $content;
    }
  }
}
