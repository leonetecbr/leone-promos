@extends('layouts.app')
@section('title', $title)
<?php $target = ($share ?? true) ? '_blank' : '_self'; ?>
@if($subtitle ?? false)
    @section('keywords', $subtitle.', promoção, menor preço, ofertas, promoções, ofertas')
    @if($isStore ?? false)
        @section('description', 'Aproveite as melhores ofertas da '.$subtitle.' na internet para você comprar com segurança!')
    @else
        @section('description', 'Aproveite as melhores ofertas de '.$subtitle.' em várias lojas da internet para você comprar com segurança!')
    @endif
@endif
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
                <div id="product-price-from" class="text-decoration-line-through h4 fw-light"></div>
            </div>
            <div class="text-muted small">Por:</div>&nbsp;
            <span id="product-price-to" class="h3"></span>
            <div id="installment" class="mt-2"></div>
        </div>
        <div id="product-desc" class="mt-3"></div>
        <div id="product-code" class="mt-3 code"><input type="text" disabled value="Acesse o link para obter o cupom"
                                                        class="form-control text-center"></div>
        <p id="share-link" class="mt-3 fw-bolder fs-5"></p>
    </div>
    <h1 class="display-5 text-center">{{ $subtitle ?? $title }}</h1>
    @include('utils.pagination')
    @if ($add ?? false)
        <div class="text-center">
            {!! $add ?? '' !!}
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center w-75 mb-4 mx-auto">{{ $error }}</div>
        @endforeach
    @endif
    @if ($catId==0 && is_array($promos) && !empty($query))
        <?php
        $url = Request::url() . '?';
        $price = Request::get('price');
        $order = Request::get('order_by');
        if (empty($price) && empty($order)) {
            $withoutOrder = $url;
            $withoutPrice = $url;
        } else {
            $withoutOrder = $url . http_build_query(['price' => $price]);
            $withoutPrice = $url . http_build_query(['order_by' => $order]);
        }
        ?>
        <div class="px-3 mt-4 mb-3 d-flex justify-content-around">
            <div class="dropdown col-5">
                <a class="btn btn-primary text-light dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    Ordenar por
                </a>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                    <li>
                        <a class="dropdown-item filtros {{ (empty($order))?'active':'' }}"
                           href="{{ (empty($order))?'#':$withoutOrder }}">Mais recentes</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($order=='discount')?'active':'' }}"
                           href="{{ ($order=='discount')?'#':$withoutOrder.'&order_by=discount' }}">Maior desconto</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($order=='price')?'active':'' }}"
                           href="{{ ($order=='price')?'#':$withoutOrder.'&order_by=price' }}">Menor Preço</a>
                    </li>
                </ul>
            </div>
            <div class="dropdown col-5">
                <a class="btn btn-primary text-light dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    Preço até
                </a>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                    <li>
                        <a class="dropdown-item filtros {{ (empty($price))?'active':'' }}"
                           href="{{ (empty($price))?'#':$withoutPrice }}">0 - </a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($price=='0-1')?'active':'' }}"
                           href="{{ ($price=='0-1')?'#':$withoutPrice.'&price=0-1' }}">0 - 1</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($price=='1-10')?'active':'' }}"
                           href="{{ ($price=='1-10')?'#':$withoutPrice.'&price=1-10' }}">1 - 10</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($price=='10-50')?'active':'' }}"
                           href="{{ ($price=='10-50')?'#':$withoutPrice.'&price=10-50' }}">10 - 50</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($price=='50-100')?'active':'' }}"
                           href="{{ ($price=='50-100')?'#':$withoutPrice.'&price=50-100' }}">50 - 100</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($price=='100-500')?'active':'' }}"
                           href="{{ ($price=='100-500')?'#':$withoutPrice.'&price=100-500' }}">100 - 500</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($price=='500-1000')?'active':'' }}"
                           href="{{ ($price=='500-1000')?'#':$withoutPrice.'&price=500-1000' }}"" href="#">500 -
                        1000</a>
                    </li>
                    <li>
                        <a class="dropdown-item filtros {{ ($price=='1000-')?'active':'' }}"
                           href="{{ ($price=='1000-')?'#':$withoutPrice.'&price=1000-' }}">1000 - </a>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    @include('utils.promo')
    @if ($add ?? false)
        <div class="text-center mt-3">
            <a href="{{ route('dashboard') }}" class="col-5">
                <button type="button" class="btn btn-danger w-75 btn-lg">Voltar</button>
            </a>
        </div>
    @endif
@endsection
@section('headers')
    {!! $headers ?? '' !!}
@endsection