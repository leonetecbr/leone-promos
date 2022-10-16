@php
    $target = ($isAdmin ?? false) ? '_blank' : '_self';
@endphp
<article id="promos" class="d-flex justify-content-around flex-wrap mb-3">
    @if($promos->count() === 0)
        <x-alert message="Nenhuma oferta encontrada!"></x-alert>
    @else
        @foreach($promos as $promo)
            <div class="promo card w-lg-30 col-md-5 col-sm-10 col-12 mb-3" id="promo-{{ $promo['id'] }}">
                @if (!($isAdmin ?? false))
                    <div class="card-header p-2">
                        <button class="border-0 share wpp">
                            <i class="bi bi-whatsapp"></i>
                        </button>
                        <button class="border-0 share tlg">
                            <i class="bi bi-telegram"></i>
                        </button>
                        <button class="border-0 share twt">
                            <i class="bi bi-twitter"></i>
                        </button>
                        <button class="border-0 share cpy pls plus-share">
                            <i class="bi bi-clipboard"></i>
                        </button>
                        <button class="border-0 share mre pls plus-share d-none">
                            <i class="bi bi-share-fill"></i>
                        </button>
                    </div>
                @endif
                <div class="card-body p-3 text-center">
                    <img src="{{ $promo['image'] }}" alt="{{ $promo['name'] }}" class="product-image mb-3"><br>
                    <h4 class="card-title">
                        <a target="{{ $target }}" href="{{ $promo['link'] }}" class="link-dark product-title">
                            {{ $promo['name'] }}
                        </a>
                    </h4>
                    @if (!empty($promo['from']) && ($promo['from']-$promo['for'])>=0.01)
                        <div class="mb-0 col-auto d-flex justify-content-center">De:&nbsp;<div
                                class="text-decoration-line-through price-from">
                                R${{ number_format($promo['from'], 2, ',', '.') }}</div>
                        </div>
                    @endif
                    <h5 class="pricing-card-title mt-3">{{ ($promo['for'] != 0) ? 'R$' . number_format($promo['for'], 2, ',', '.') : 'Grátis' }}</h5>
                    <p class="installment text-muted">
                        @if ($promo['times']!==1 && $promo['times']!==NULL)
                            {{ $promo['times'] }}
                            x {{ (($promo['installments'] * $promo['times']) <= $promo['for']+0.05) ? 'sem juros' : '' }}
                            de
                            R${{ number_format($promo['installments'], 2, ',', '.') }}
                        @elseif ($promo['for'] > 0)
                            Apenas à vista!
                        @endif
                    </p>
                    @if (!empty($promo['description']))
                        <p class="description">{!! $promo['description'] !!}</p>
                    @endif
                    @if (!empty($promo['code']))
                        <div class="code row col-11 mx-auto">
                            <input value="{{ $promo['code'] }}" disabled class="form-control text-center code-text">
                        </div>
                    @endif
                </div>
                <div class="final text-center p-3">
                    <div class="text-end">
                        <a target="{{ $target }}" href="{{ $promo['store']['link'] }}">
                            <img src="{{ $promo['store']['image'] }}" alt="{{ $promo['store']['name'] }}" class="loja">
                        </a>
                    </div>
                    <div class="d-xl-flex">
                        @if ($isAdmin ?? false)
                            <a target="{{ $target }}" href="{{ $promo['link'] }}"
                               class="btn btn-outline-danger w-75 mx-auto">
                                Editar promoção
                            </a>
                        @else
                            <a target="{{ $target }}" href="{{ $promo['link'] }}"
                               class="btn btn-secondary col-xl-5 col-10 mx-auto">
                                Ver comentários
                            </a>
                            @if (empty($promo['code']))
                                <a target="{{ $target }}" href="{{ $promo['link'] }}"
                                   class="btn btn-primary text-white col-xl-5 col-10 my-2 my-xl-0 mx-auto">
                                    Ir para a loja
                                </a>
                            @else
                                <button data-link="{{ $promo['link'] }}"
                                        class="btn btn-primary text-white col-xl-5 col-10 mx-auto copy-redirect">
                                    Copiar e ir para a loja
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        <div class="container text-center flex-column fs-6" id="btnTop">
            <button class="rounded bg-primary px-3 py-2 border-0">
                <i class="bi bi-arrow-up text-white"></i>
            </button>
            <p class="fs-5 my-2 fw-light">Topo</p>
        </div>
        <div class="container text-center text-muted">
            *Ofertas válidas enquanto durarem os estoques e sujeitas a disponibilidade do lote de cupons!
        </div>
    @endif
</article>
