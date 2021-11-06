@extends('layouts.app')
@section('title')
Cupons: Página {{ $page }} de {{ $final }}
@endsection
@section('keywords', 'cupom, desconto, cupom de desconto, Americanas, Casas Bahia, Ponto Frio, Amazon, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Está de olho naquele produto tão desejado, mas precisa de um desconto antes de fechar a compra ? Aqui você encontra os cupons de desconto que ainda funcionam para usar nas maiores lojas do Brasil.')
@section('content')
<h1 class="display-5 text-center">Cupons</h1>
@include('utils.pagination')
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
<div class="container text-center flex-column fs-12 bolder top"><button class="rounded bg-primary px-3 py-2 border-0" onclick="$('html, body').animate({scrollTop : 0},800);" id="btn-top"><i class="fas fa-angle-double-up text-white"></i></button>
  <p class="fs-5 my-2 fw-light">Topo</p>
</div>
@endsection