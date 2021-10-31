@extends('layouts.app')
@section('title', 'Home')
@section('keywords', 'Leone Promos, melhores promoções, promoções, preço baixo, comprar online')
@section('content')
<div id="banner" class="container center">
  <div class="title">
    <h2>PROMOÇÕES</h2>
    <h3>As melhores promoções da internet para você aproveitar com total segurança! Confira nossa seleção de ofertas, de cupons, navegue pelas categorias ou então sinta-se livre para fazer pesquisas em nossa seleção de ofertas.</h3>
  </div>
  <div id="buttons">
    <a href="/cupons"><button class="btn bg-white radius center"><i class="fas fa-tags"></i> Cupons</button></a>
    <a href="/categorias"><button class="btn bg-black radius center"><i class="fas fa-list"></i> Categorias</button></a>
    <a href="/lojas"><button class="btn radius bg-orange"><i class="fas fa-store"></i> Lojas</button></a>
  </div>
</div>
<h2 class="container" id="title">Melhores promoções</h2>
<article id="promos" class="container center">
  <div id="noeye"></div>
  @if (empty($top_promos))
  <p class="m-auto">Nenhuma oferta encontrada!</p>
</article>
@else
@foreach ($top_promos as $promo)
<div class="promo bg-white" id="{{ $cat_id }}_{{ $page }}_{{ $loop->index }}">
  @if ($share??true)
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
  @endif
  <div class="inner">
    <img src="{{ $promo['imagem'] }}" alt="{{ $promo['nome'] }}" class="product-image" /><br />
    <a target="_blank" href="{{ $promo['link'] }}" class="product-title">{{ mb_strimwidth($promo['nome'], 0, 50, '...' ) }}</a>
    @if (!empty($promo['discount']) && $promo['discount']>=0.01)
    <p>De: <del>R$ {{ number_format($promo['de'], 2, ',', '.') }}</del></p>
    @endif
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
    <div class="loja"><a target="_blank" href="{{ $promo['store']['link'] }}"><img src="{{ $promo['store']['imagem'] }}" alt="{{ $promo['store']['nome'] }}"></a></div>
  </div>
  @if (empty($promo['code']))
  <a target="_blank" href="{{ $promo['link'] }}"><button class="bg-black radius">
      Ir para a loja
    </button></a>
  @else
  <button onclick="copy('{{ $promo['link'] }}', '#input{{ $loop->index }}')" class="fs-12 btn bg-black radius">Copiar e ir para a loja</button>
  @endif
</div>
@endforeach
</article>
<div class="flex-column m-auto fs-12 bolder top"><button class="bg-orange radius" onclick="$('html, body').animate({scrollTop : 0},800);" id="btn-top"><i class="fas fa-angle-double-up text-white"></i></button>
  <p>Topo</p>
</div>
@endif
<h2 class="container h2">Verificar promoção</h2>
<p class="container">Está com dúvidas se está na pagina real? Não sabe se a promoção é verdadeira? Cole o link da promoção abaixo e você será redirecionado para essa promoção com total segurança.</p>
<form id="deeplink" class="container center" novalidate autocomplete="off">
  <label for="name">Link:</label> <input type="url" id="url" placeholder="Digite o link da promoção ..." name="url" class="radius"><br />
  <div class="small erro iurl center hidden"><br>Link inválido! Lembre-se de usar "https://".</div><br />
  <button type="submit" class="bg-black radius">Ir para a promoção</button>
</form>
@endsection