@extends('layouts.app')
@section('title', 'Cupons')
<?
$imin = (intval($page)-1)*18;
$imax = intval($page)*18;
?>
@section('content')
<h2 class="container" id="title">Cupons</h2>
{!! $pages??'' !!}
<div id="cupons" class="container center">
<div id="noeye"></div>
<article class="container center">
@for ($i = $imin; $i < $imax; $i++)
  <div class="cupom bg-white radius" id="cupom_{{ $i }}">
    <!--div class="share">
      <p><a href="#story" class="igs"><i class="fab fa-instagram"></i></a>
           <a href="#whatsapp" class="wpp" target="_blank"><i class="fab fa-whatsapp"></i></a>
           <a href="#telegram" class="tlg" target="_blank"><i class="fab fa-telegram-plane"></i></a>
            <a href="#messenger" class="fbm" target="_blank"><i class="fab fa-facebook-messenger"></i></a>
            <a href="#twitter" class="twt" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="#copy" class="pls plus-share"><i class="fas fa-copy"></i></a>
            <a href="#share" class="pls hidden plus-share"><i class="fas fa-share-alt"></i></a></p>
    </div-->
    <div class="inner">
        <div class="site"><img src="{{ $cupons[$i]['store']['image'] }}" alt="{{ $cupons[$i]['store']['name'] }}"></div>
        <h4><? echo mb_strimwidth($cupons[$i]['description'], 0, 100, '...' ); ?></h4>
        <p>Válido até <? echo str_replace(":59:00", ":59:59", $cupons[$i]['vigency']); ?></p>
        <p class="code">Cupom: <input value="{{ $cupons[$i]['code'] }}" disabled="true" class="center" id="input_{{ $i }}"/></p>
        </div>
        <div class="final">
        <button onclick="copy('{{ $cupons[$i]['link'] }}', '#input_{{ $i }}')" class="bg-black radius">
          Copiar e ir para a loja</button>
        </div>
    </div>
@endfor
</article>
<div class="flex-column flex-center fs-12 bolder top"><button class="padding bg-orange" onclick="$('html, body').animate({scrollTop : 0},800);"><i class="fas fa-angle-double-up text-white"></i></button><p>Topo</p>
</div>
</div>
@endsection