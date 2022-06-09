@extends('layouts.app')
@section('title', 'Home')
@section('keywords', 'Leone Promos, promoção, menor preço, ofertas, promoções, oferta')
@section('content')
    <div id="ig-share" class="d-none fixed-top bg-white p-3 w-100 h-100 text-center">
        <div id="logomarca" class="border-bottom mh-10">
            <img src="{{ url('/img/logo.png') }}" alt="Logo" class="mx-auto">
        </div>
        <img id="product-image" class="my-3 mh-33" alt="Imagem do produto">
        <h4 class="h4" id="product-title"></h4>
        <div class="mt-3 fs-5">
            <div id="price-from" class="mb-3">
                <div class="text-muted small">De:</div>&nbsp;
                <div id="product-price-from" class="h4 fw-light text-decoration-line-through"></div>
            </div>
            <div class="text-muted small">Por:</div>&nbsp;
            <span id="product-price-to" class="h3"></span>
            <div id="installment" class="mt-2"></div>
        </div>
        <div id="product-desc" class="mt-3"></div>
        <div id="product-code" class="mt-3 code">
            <input type="text" disabled value="Acesse o link para obter o cupom" class="form-control text-center">
        </div>
        <p id="share-link" class="mt-3 fw-bolder fs-5"></p>
    </div>
    <div id="banner" class="d-md-flex justify-content-between my-3">
        <div class="title col-md-8">
            <h2 class="display-5 mb-3">PROMOÇÕES</h2>
            <h3 class="mb-2">As melhores promoções da internet para você aproveitar com total segurança! Confira nossa seleção de ofertas, de cupons, navegue pelas categorias ou então sinta-se livre para fazer pesquisas em nossa seleção de ofertas.</h3>
        </div>
        <div class="col-md-3">
            <a href="{{ route('cupons') }}">
                <button class="btn btn-secondary btn-lg w-100 mt-3">
                    <i class="fas fa-tags"></i> Cupons
                </button>
            </a>
            <a href="{{ route('categorias') }}">
                <button class="btn btn-dark btn-lg w-100 mt-3">
                    <i class="fas fa-list"></i> Categorias
                </button>
                </a>
            <a href="{{ route('lojas') }}">
                <button class="btn text-light btn-primary btn-lg w-100 mt-3"><i class="fas fa-store"></i> Lojas
                </button>
            </a>
        </div>
    </div>
    <h2 class="display-6 mb-4 mt-2">Melhores promoções</h2>
    @include('utils.promo')
    <h2 class="display-6">Verificar promoção</h2>
    <p class="f-5 my-3">Está com dúvidas se está na pagina real? Não sabe se a promoção é verdadeira? Cole o link da promoção abaixo e você será redirecionado para essa promoção com total segurança.</p>
    <form id="deeplink" novalidate autocomplete="off" class="needs-validation justify-content-center row">
        <div class="col-7">
            <label for="url" class="visually-hidden">Link</label>
            <input type="url" id="url" placeholder="Digite o link da promoção ..." name="url" class="form-control" required>
            <div class="invalid-feedback">Link inválido! Lembre-se de usar "https://".</div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn text-light btn-primary">Checar</button>
        </div>
    </form>
@endsection