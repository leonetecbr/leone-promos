@extends('layouts.app')
@section('title', $title)
<?php $target = ($share ?? true) ? '_blank' : '_self'; ?>
@if($subtitle??false)
  @section('keywords', $subtitle.', promoção, menor preço, ofertas, promoções, ofertas')
  @if($isLoja??false)
    @section('description', 'Aproveite as melhores ofertas da '.$subtitle.' na internet para você comprar com segurança!')
  @else
    @section('description', 'Aproveite as melhores ofertas de '.$subtitle.' em várias lojas da internet para você comprar com segurança!')
  @endif
@endif
@section('content')
<h1 class="container" id="title">{{ $subtitle??$title }}</h1>
{!! $pages??'' !!}
@if ($add??false)
<div class="container center">
  {!! $add??'' !!}
</div>
@endif

<article id="promos" class="container center">
  <div id="noeye"></div>
  @if ($errors->any())
  <div class="w100 alert erro mb-2">
    @foreach ($errors->all() as $error)
    <p class="center">{{ $error }}</p>
    @endforeach
  </div>
  @endif
  @if (empty($promos))
  <p class="m-auto">Nenhuma oferta encontrada!</p>
</article>
@elseif (is_array($promos))
@foreach ($promos as $promo)
<div class="promo bg-white" id="{{ $cat_id }}_{{ $page }}_{{ $loop->index }}">
  @if ($share??true)
  <div class="share">
    <p>
      <a href="#story" class="igs"><i class="fab fa-instagram"></i></a>
      <a href="#whatsapp" class="wpp"><i class="fab fa-whatsapp"></i></a>
      <a href="#telegram" class="tlg"><i class="fab fa-telegram-plane"></i></a>
      <a href="#twitter" class="twt"><i class="fab fa-twitter"></i></a>
      <a href="#copy" class="cpy pls plus-share"><i class="fas fa-copy"></i></a>
      <a href="#share" class="mre pls d-none plus-share"><i class="fas fa-share-alt"></i></a>
    </p>
  </div>
  @endif
  <div class="inner">
    <img src="{{ $promo['imagem'] }}" alt="{{ $promo['nome'] }}" class="product-image" /><br />
    <a target="{{ $target }}" href="{{ $promo['link'] }}" class="product-title">{{ mb_strimwidth($promo['nome'], 0, 50, '...' ) }}</a>
    <h4>{{ ($promo['por'] != 0)? 'R$' . number_format($promo['por'], 2, ',', '.') : 'Grátis'; }}</h4>
    <p class="installment">
      @if ($promo['vezes']!==1 && $promo['vezes']!==NULL)
      {{ $promo['vezes'] }}x{{ (($promo['parcelas']*$promo['vezes']) <= $promo['por']+0.05)?' sem juros':''; }} de R$ {{ number_format($promo['parcelas'], 2, ',', '.') }}
      @elseif ($promo['por'] != 0)
      Apenas à vista!
      @endif
    </p>
    @if (!empty($promo['desc']))
    <p class="description">{!! $promo['desc'] !!}</p>
    @endif
    @if (!empty($promo['code']))
    <p class="code">Cupom: <input value="{{ $promo['code'] }}" disabled="true" class="center discount" id="input{{ $loop->index }}" /></p>
    @endif
  </div>
  <div class="final">
    <div class="loja"><a target="{{ $target }}" href="{{ $promo['store']['link'] }}"><img src="{{ $promo['store']['imagem'] }}" alt="{{ $promo['store']['nome'] }}"></a></div>
  </div>
  @if (empty($promo['code']))
  <a target="{{ $target }}" href="{{ $promo['link'] }}"><button class="bg-black radius">
      Ir para a loja
    </button></a>
  @else
  <button onclick="copy('{{ $promo['link'] }}', '#input{{ $loop->index }}')" class="fs-12 btn bg-black radius">Copiar e ir para a loja</button>
  @endif
</div>
@endforeach
</article>
@if ($topo??true)
<div class="flex-column m-auto fs-12 bolder top"><button class="padding bg-orange" onclick="$('html, body').animate({scrollTop : 0},800);"><i class="fas fa-angle-double-up text-white"></i></button>
  <p>Topo</p>
  @endif
  @else
  {!! $promos !!}</article>
  @endif
  @endsection
  @section('headers')
  {!! $headers??'' !!}
  @endsection