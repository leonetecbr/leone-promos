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
<h1 class="display-5 text-center">{{ $subtitle??$title }}</h1>
@include('utils.pagination')
@if ($add??false)
<div class="text-center">
  {!! $add??'' !!}
</div>
@endif
@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-danger text-center w-75 mb-4 mx-auto">{{ $error }}</div>
@endforeach
@endif
<article id="promos" class="d-flex justify-content-around flex-wrap">
  <div id="noeye"></div>
  @if (empty($promos))
  <p class="m-auto">Nenhuma oferta encontrada!</p>
</article>
@elseif (is_array($promos))
@foreach ($promos as $promo)
<div class="promo card col-lg-3-5 col-md-5 col-sm-10 col-12 mb-5" id="{{ $cat_id }}_{{ $page }}_{{ $loop->index }}">
    @if ($share??true)
    <div class="card-header p-2">
      <button class="border-0 igs"><i class="fab fa-instagram"></i></button>
      <button class="border-0 wpp"><i class="fab fa-whatsapp"></i></button>
      <button class="border-0 tlg"><i class="fab fa-telegram-plane"></i></button>
      <button class="border-0 twt"><i class="fab fa-twitter"></i></button>
      <button class="border-0 cyp pls plus-share"><i class="fas fa-copy"></i></button>
      <button class="border-0 mre pls d-none plus-share"><i class="fas fa-share-alt"></i></button>
    </div>
    @endif
    <div class="card-body p-3 text-center">
      <img src="{{ $promo['imagem'] }}" alt="{{ $promo['nome'] }}" class="product-image mb-3" /><br />
      <h4 class="card-title"><a target="_blank" href="{{ $promo['link'] }}" class="text-decoration-none link-dark product-title">{{ $promo['nome'] }}</a></h4>
      <h5 class="pricing-card-title mt-3">{{ ($promo['por'] != 0)? 'R$' . number_format($promo['por'], 2, ',', '.') : 'Grátis'; }}</h5>
      <p class="installment text-muted">
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
      <div class="code row col-11 mx-auto"><input value="{{ $promo['code'] }}" disabled="true" class="form-control text-center discount" id="input{{ $loop->index }}" /></div>
      @endif
    </div>
    <div class="final text-center p-3">
      <div class="text-end"><a target="_blank" href="{{ $promo['store']['link'] }}"><img src="{{ $promo['store']['imagem'] }}" alt="{{ $promo['store']['nome'] }}" class="loja"></a></div>
      @if (empty($promo['code']))
        <a target="_blank" href="{{ $promo['link'] }}" class="mx-auto"><button class="btn btn-outline-danger w-75">Ir para a loja</button></a>
      @else
        <button onclick="copy('{{ $promo['link'] }}', '#input{{ $loop->index }}')" class="btn btn-outline-danger w-75 mx-auto">Copiar e ir para a loja</button>
      @endif
    </div>
  </div>
</div>
@endforeach
</article>
@if ($topo??true)
<div class="container text-center flex-column fs-12 bolder top"><button class="rounded bg-primary px-3 py-2 border-0" onclick="$('html, body').animate({scrollTop : 0},800);" id="btn-top"><i class="fas fa-angle-double-up text-white"></i></button>
  <p class="fs-5 my-2 fw-light">Topo</p>
</div>
  @endif
  @else
  {!! $promos !!}</article>
  @endif
@endsection
@section('headers')
  {!! $headers??'' !!}
@endsection