@extends('layouts.app')
@section('title')
    Cupons{{ (empty($store))?'':' - '.$store }}: Página {{ $page }} de {{ $endPage }}
@endsection
@section('keywords', 'cupom, desconto, cupom de desconto, Americanas, Casas Bahia, Ponto Frio, Amazon, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Está de olho naquele produto tão desejado, mas precisa de um desconto antes de fechar a compra ? Aqui você encontra os cupons de desconto que ainda funcionam para usar nas maiores lojas do Brasil.')
@section('content')
    <h1 class="display-5 text-center">Cupons{{ (empty($store))?'':': '.$store }}</h1>
    @include('utils.pagination')
    <div class="dropdown my-4 col-md-6 mx-auto">
        <button class="btn btn-primary text-light dropdown-toggle w-100" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
            Escolher lojas
        </button>
        <ul class="dropdown-menu w-100 text-center" aria-labelledby="dropdownMenuButton1">
            <li>
                <a class="dropdown-item{{ ($store=='')?' active':''; }}" href="{{ route('cupons') }}">Todas</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Americanas')?' active':''; }}"
                   href="{{ route('cupons') }}?loja=Americanas">Americanas</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Casas Bahia')?' active':''; }}"
                   href="{{ route('cupons') }}?loja=Casas Bahia">Casas Bahia</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Consul')?' active':''; }}" href="{{ route('cupons') }}?loja=Consul">Consul</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Ponto')?' active':''; }}" href="{{ route('cupons') }}?loja=Ponto">Ponto</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Submarino')?' active':''; }}"
                   href="{{ route('cupons') }}?loja=Submarino">Submarino</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Efácil')?' active':''; }}" href="{{ route('cupons') }}?loja=Efácil">Efácil</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Positivo')?' active':''; }}"
                   href="{{ route('cupons') }}?loja=Positivo">Positivo</a>
            </li>
            <li>
                <a class="dropdown-item{{ ($store=='Lenovo')?' active':''; }}" href="{{ route('cupons') }}?loja=Lenovo">Lenovo</a>
            </li>
        </ul>
    </div>
    <article id="cupons" class="container d-flex justify-content-around flex-wrap">
        @if (empty($coupons))
            <p class="mx-auto my-3 alert alert-warning w-75 text-center">Nenhum cupom encontrado!</p>
    </article>
    @else
        @foreach ($coupons as $coupon)
            <div class="cupom card col-lg-3-5 col-md-5 col-sm-10 col-12 mb-5" id="cupom-{{ $loop->index }}">
                <div class="card-header p-2">
                    <button class="border-0 wpp"><i class="fab fa-whatsapp"></i></button>
                    <button class="border-0 tlg"><i class="fab fa-telegram-plane"></i></button>
                    <button class="border-0 twt"><i class="fab fa-twitter"></i></button>
                    <button class="border-0 cpy pls plus-share"><i class="fas fa-copy"></i></button>
                    <button class="border-0 mre pls d-none plus-share"><i class="fas fa-share-alt"></i></button>
                </div>
                <div class="card-body p-3 text-center mb-md-3">
                    <div class="site mb-3">
                        <img src="{{ $coupon['store']['image'] }}" alt="{{ $coupon['store']['name'] }}" class="loja-image">
                    </div>
                    <h4 class="card-title">{{ mb_strimwidth($coupon['description'], 0, 100, '...' ) }}</h4>
                    <div class="cupom-vigency my-3">Válido até {{ $coupon['expiration'] }}</div>
                    <div class="code row col-11 mx-auto">
                        <input value="{{ $coupon['code'] }}" disabled
                               class="form-control text-center code-text"/>
                    </div>
                </div>
                <div class="final text-center p-3">
                    <button data-link="{{ $coupon['link'] }}" class="btn btn-outline-danger w-75 mx-auto copy-redirect">
                        Copiar e ir para a loja
                    </button>
                </div>
            </div>
            @endforeach
            </article>
            <div class="container text-center flex-column fs-12 bolder top" id="btn-topo">
                <button class="rounded bg-primary px-3 py-2 border-0">
                    <i class="fas fa-angle-double-up text-white"></i>
                </button>
                <p class="fs-5 my-2 fw-light">Topo</p>
            </div>
            <div class="container text-center text-muted">
                *Sujeito a disponibilidade do lote de cupons
            </div>
            @endif
            @endsection