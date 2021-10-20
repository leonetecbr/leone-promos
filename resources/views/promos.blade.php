@extends('layouts.app')
@section('title', $title)
<?php $target = ($share??true)?'_blank':'_self';?>
@section('content')
<h2 class="container" id="title">{{ $subtitle??$title }}</h2>
{!! $pages??'' !!}
@if ($add??false)
<div class="container center">
{!! $add??'' !!}
</div>
@endif
<article id="promos" class="container center">
  <div id="noeye"></div>
  @if ($errors->any())
    <div class="alert erro center mt-1">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif
  @if (empty($promos))
    <p class="m-auto">Nenhuma oferta encontrada!</p></article>
  @elseif (is_array($promos))
    @foreach ($promos as $promo)
      <div class="promo bg-white" id="{{ $cat_id }}_{{ $page }}_{{ $loop->index }}">
        @if ($share??false)
          <div class="share">
            <p><a href="#story" class="igs"><i class="fab fa-instagram"></i></a>
              <a href="#whatsapp" class="wpp" target="_blank"><i class="fab fa-whatsapp"></i></a>
              <a href="#telegram" class="tlg" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                <a href="#messenger" class="fbm" target="_blank"><i class="fab fa-facebook-messenger"></i></a>
                <a href="#twitter" class="twt" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="#copy" class="pls plus-share"><i class="fas fa-copy"></i></a>
                <a href="#share" class="pls hidden plus-share"><i class="fas fa-share-alt"></i></a></p>
          </div>
        @endif
          <div class="inner">
            <img src="{{ $promo['thumbnail'] }}" alt="{{ $promo['name'] }}" class="product-image"/><br/>
            <a target="{{ $target }}" href="{{ $promo['link'] }}" class="product-title">{{ mb_strimwidth($promo['name'], 0, 50, '...' ) }}</a>
            @if (!empty($promo['discount']) && $promo['discount']>=0.01)
            <p>De: <del>R$ {{ number_format($promo['priceFrom'], 2, ',', '.') }}</del></p>
          @endif
          <h4>
            @if ($promo['price'] != 0)
              R$ {{ number_format($promo['price'], 2, ',', '.') }}
            @else
              Grátis
            @endif
          </h4>
          <p class="installment">
          @if (!empty($promo['installment']))
            {{ $promo['installment']['quantity'] }}x{{ (($promo['installment']['quantity']*$promo['installment']['value']) <= $promo['price']+0.05)?' sem juros':''; }} de R$ {{ number_format($promo['installment']['value'], 2, ',', '.') }}
          @elseif ($promo['price'] != 0)
            Apenas à vista!
          @endif
          </p>
            @if (!empty($promo['description']))
              <p class="description">{!! $promo['description'] !!}</p>
            @endif
            @if (!empty($promo['code']))
              <p class="code">Cupom: <input value="{{ $promo['code'] }}" disabled="true" class="center discount" id="input{{ $loop->index }}"/></p>
            @endif
            </div>
            <div class="final">
            <div class="loja"><a target="{{ $target }}" href="{{ $promo['store']['link'] }}"><img src="{{ $promo['store']['thumbnail'] }}" alt="{{ $promo['store']['name'] }}"></a></div>
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
      <div class="flex-column m-auto fs-12 bolder top"><button class="padding bg-orange" onclick="$('html, body').animate({scrollTop : 0},800);"><i class="fas fa-angle-double-up text-white"></i></button><p>Topo</p>
    @endif
  @else
    {!! $promos !!}</article>
  @endif
@endsection
@section('headers')
{!! $headers??'' !!}
@endsection