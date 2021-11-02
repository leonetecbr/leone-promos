@extends('layouts.app')
@section('title')
Cupons: Página {{ $page }} de {{ $total }}
@endsection
@section('keywords', 'cupom, desconto, cupom de desconto, Americanas, Casas Bahia, Ponto Frio, Amazon, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Está de olho naquele produto tão desejado, mas precisa de um desconto antes de fechar a compra ? Aqui você encontra os cupons de desconto que ainda funcionam para usar nas maiores lojas do Brasil.')
@section('content')
<h1 class="container" id="title">Cupons</h1>
{!! $pages??'' !!}
<article id="cupons" class="container center">
  <div id="noeye"></div>
  @for ($i = 0; $i < count($cupons); $i++) <div class="cupom bg-white radius" id="cupom_{{ $i }}">
    <div class="share">
      <p>
        <a href="#whatsapp" class="wpp"><i class="fab fa-whatsapp"></i></a>
        <a href="#telegram" class="tlg"><i class="fab fa-telegram-plane"></i></a>
        <a href="#twitter" class="twt"><i class="fab fa-twitter"></i></a>
        <a href="#copy" class="cpy pls plus-share"><i class="fas fa-copy"></i></a>
        <a href="#share" class="mre pls d-none plus-share"><i class="fas fa-share-alt"></i></a>
      </p>
    </div>
    <div class="inner">
      <div class="site"><img src="{{ $cupons[$i]['store']['imagem'] }}" alt="{{ $cupons[$i]['store']['nome'] }}" class="product-image"></div>
      <h4>{{ mb_strimwidth($cupons[$i]['desc'], 0, 100, '...' ) }}</h4>
      <p class="cupom-vigency">Válido até {{ $cupons[$i]['ate'] }}</p>
      <p class="code">Cupom: <input value="{{ $cupons[$i]['code'] }}" disabled="true" class="center cupom-code" id="input_{{ $i }}" /></p>
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