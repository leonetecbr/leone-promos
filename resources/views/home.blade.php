@extends('layouts.app')
@section('title', 'Home')
@section('keywords', 'Leone Promos, promoção, menor preço, ofertas, promoções, oferta')
@section('content')
<div id="banner" class="d-md-flex justify-content-between my-3">
  <div class="title col-md-8">
    <h2 class="display-5 mb-3">PROMOÇÕES</h2>
    <h3 class="mb-2">As melhores promoções da internet para você aproveitar com total segurança! Confira nossa seleção de ofertas, de cupons, navegue pelas categorias ou então sinta-se livre para fazer pesquisas em nossa seleção de ofertas.</h3>
  </div>
  <div class="col-md-3">
    <a href="{{ route('cupons') }}"><button class="btn btn-secondary btn-lg w-100 mt-3"><i class="fas fa-tags"></i> Cupons</button></a>
    <a href="{{ route('categorias') }}"><button class="btn btn btn-dark btn-lg w-100 mt-3"><i class="fas fa-list"></i> Categorias</button></a>
    <a href="{{ route('lojas') }}"><button class="btn btn btn-orange btn-lg w-100 mt-3"><i class="fas fa-store"></i> Lojas</button></a>
  </div>
</div>
<h2 class="display-6 mb-4 mt-2">Melhores promoções</h2>
<article id="promos" class="d-flex justify-content-between flex-wrap">
  <div id="noeye"></div>
  @if (empty($top_promos))
  <p class="m-auto">Nenhuma oferta encontrada!</p>
</article>
@else
@foreach ($top_promos as $promo)
<div class="promo col-lg-3-5 col-md-5 col-sm-10 col-12 mb-5" id="{{ $cat_id }}_{{ $page }}_{{ $loop->index }}">
  <div class="card shadow-sm">
    @if ($share??true)
    <div class="card-header p-2">
        <a href="#story" class="igs"><i class="fab fa-instagram"></i></a>
        <a href="#whatsapp" class="wpp"><i class="fab fa-whatsapp"></i></a>
        <a href="#telegram" class="tlg"><i class="fab fa-telegram-plane"></i></a>
        <a href="#twitter" class="twt"><i class="fab fa-twitter"></i></a>
        <a href="#copy" class="cpy pls plus-share"><i class="fas fa-copy"></i></a>
        <a href="#share" class="mre pls d-none plus-share"><i class="fas fa-share-alt"></i></a>
    </div>
    @endif
    <div class="card-body p-2 text-center">
      <img src="{{ $promo['imagem'] }}" alt="{{ $promo['nome'] }}" class="product-image mb-3" /><br />
      <h4 class="card-title"><a target="_blank" href="{{ $promo['link'] }}" class="text-decoration-none link-dark">{{ $promo['nome'] }}</a></h4>
      @if (!empty($promo['de']) && ($promo['de']-$promo['por'])>=0.01)
      <p class="mb-2">De: <del>R$ {{ number_format($promo['de'], 2, ',', '.') }}</del></p>
      @endif
      <h5 class="pricing-card-title">{{ ($promo['por'] != 0)? 'R$' . number_format($promo['por'], 2, ',', '.') : 'Grátis'; }}</h5>
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
      <div class="code row col-11 mx-auto"><input value="{{ $promo['code'] }}" disabled="true" class="center form-control text-center" id="input{{ $loop->index }}" /></div>
      @endif
    </div>
    <div class="final text-center p-2">
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
<div class="flex-column m-auto fs-12 bolder top"><button class="bg-orange radius border-0" onclick="$('html, body').animate({scrollTop : 0},800);" id="btn-top"><i class="fas fa-angle-double-up text-white"></i></button>
  <p>Topo</p>
</div>
@endif
<h2 class="container h2">Verificar promoção</h2>
<p class="container">Está com dúvidas se está na pagina real? Não sabe se a promoção é verdadeira? Cole o link da promoção abaixo e você será redirecionado para essa promoção com total segurança.</p>
<form id="deeplink" class="container center" novalidate autocomplete="off">
  <label for="name">Link:</label> <input type="url" id="url" placeholder="Digite o link da promoção ..." name="url" class="radius"><br />
  <div class="small erro iurl center d-none"><br>Link inválido! Lembre-se de usar "https://".</div><br />
  <button type="submit" class="bg-black radius">Ir para a promoção</button>
</form>
@endsection