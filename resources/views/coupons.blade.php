@extends('layouts.app')
@section('title')
    Cupons{{ !empty($store) && $store->name }}: Página {{ $coupons->currentPage() }} de {{ $coupons->lastPage() }}
@endsection
@section('keywords', 'cupom, desconto, cupom de desconto, Casas Bahia, Ponto Frio, Amazon, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Está de olho naquele produto tão desejado, mas precisa de um desconto antes de fechar a compra ? Aqui você encontra os cupons de desconto que ainda funcionam para usar nas maiores lojas do Brasil.')
@section('content')
    <h1 class="display-5 text-center">
        Cupons{{ (empty($store) || !is_array($coupons)) ? '' : ': ' . $store }}
    </h1>
    {{--    <div class="dropdown my-4 col-md-6 mx-auto">--}}
    {{--        <button class="btn btn-primary text-light dropdown-toggle w-100" type="button" id="dropdownMenuButton1"--}}
    {{--                data-bs-toggle="dropdown" aria-expanded="false">--}}
    {{--            Escolher lojas--}}
    {{--        </button>--}}
    {{--        <ul class="dropdown-menu w-100 text-center" aria-labelledby="dropdownMenuButton1">--}}
    {{--            @foreach($topStores as $storeName => $id)--}}
    {{--                <li>--}}
    {{--                    <a class="dropdown-item{{ ($store==$storeName)?' active':''; }}"--}}
    {{--                       href="{{ route('cupons').'?loja='.$storeName }}">{{ $storeName }}</a>--}}
    {{--                </li>--}}
    {{--            @endforeach--}}
    {{--        </ul>--}}
    {{--    </div>--}}
    <article id="coupons" class="container d-flex justify-content-around flex-wrap mt-3">
        @if ($coupons->isEmpty())
            <dic class="alert alert-warning w-75 mx-auto" role="alert">
                Nenhum cupom encontrado!
            </dic>
        @else
            @foreach ($coupons as $coupon)
                <div class="coupon card col-lg-3-5 col-md-5 col-sm-10 col-12 mb-5" id="coupon-{{ $coupon->id }}">
                    <div class="card-header p-2">
                        <button class="border-0 wpp"><i class="fab fa-whatsapp"></i></button>
                        <button class="border-0 tlg"><i class="fab fa-telegram-plane"></i></button>
                        <button class="border-0 twt"><i class="fab fa-twitter"></i></button>
                        <button class="border-0 cpy pls plus-share"><i class="fas fa-copy"></i></button>
                        <button class="border-0 mre pls d-none plus-share"><i class="fas fa-share-alt"></i></button>
                    </div>
                    <div class="card-body p-3 text-center mb-md-3">
                        <div class="site mb-3">
                            <img src="{{ $coupon->store->image }}" alt="{{ $coupon->store->name }}" class="store-image">
                        </div>
                        <h4 class="card-title">{{ mb_strimwidth($coupon['description'], 0, 100, '...' ) }}</h4>
                        @if($coupon->expires_at)
                            <div class="cupom-validity mt-3">Válido até {{ $coupon->expires_at }}</div>
                        @endif
                        <div class="code row col-11 mx-auto mt-3">
                            <input value="{{ $coupon['code'] }}" disabled class="form-control text-center code-text"/>
                        </div>
                    </div>
                    <div class="card-end text-center p-3">
                        <button data-link="{{ $coupon['link'] }}" class="btn btn-outline-danger w-75 mx-auto copy-redirect">
                            Copiar e ir para a loja
                        </button>
                    </div>
                </div>
            @endforeach
            <div class="container">
                {{ $coupons->onEachSide(0)->links() }}
            </div>
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
    </article>
@endsection
