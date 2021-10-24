@extends('layouts.app')
<?php
$imin = (intval($page) - 1) * 18;
$imax = intval($page) * 18;
?>
@section('title')
Cupons: Página {{ $page }} de {{ $imax }}
@endsection
@section('content')
<h1 class="container" id="title">Cupons</h1>
{!! $pages??'' !!}
<article id="cupons" class="container center">
  <div id="noeye"></div>
  @for ($i = $imin; $i < $imax; $i++) <div class="cupom bg-white radius" id="cupom_{{ $i }}">
    <div class="share">
      <p>
        <a href="#story" class="igs"><i class="fab fa-instagram"></i></a>
        <a href="#whatsapp" class="wpp"><i class="fab fa-whatsapp"></i></a>
        <a href="#telegram" class="tlg"><i class="fab fa-telegram-plane"></i></a>
        <a href="#twitter" class="twt"><i class="fab fa-twitter"></i></a>
        <a href="#copy" class="cpy pls plus-share"><i class="fas fa-copy"></i></a>
        <a href="#share" class="mre pls hidden plus-share"><i class="fas fa-share-alt"></i></a>
      </p>
    </div>
    <div class="inner">
      <div class="site"><img src="{{ $cupons[$i]['store']['image'] }}" alt="{{ $cupons[$i]['store']['name'] }}"></div>
      <h4>{{ mb_strimwidth($cupons[$i]['description'], 0, 100, '...' ) }}</h4>
      <p>Válido até {{ str_replace(":59:00", ":59:59", $cupons[$i]['vigency']) }}</p>
      <p class="code">Cupom: <input value="{{ $cupons[$i]['code'] }}" disabled="true" class="center" id="input_{{ $i }}" /></p>
    </div>
    <div class="final">
      <button onclick="copy('{{ $cupons[$i]['link'] }}', '#input_{{ $i }}')" class="bg-black radius">
        Copiar e ir para a loja</button>
    </div>
    </div>
    @endfor
</article>
<div class="flex-column m-auto fs-12 bolder top"><button class="padding bg-orange" onclick="$('html, body').animate({scrollTop : 0},800);"><i class="fas fa-angle-double-up text-white"></i></button>
  <p>Topo</p>
</div>
@endsection