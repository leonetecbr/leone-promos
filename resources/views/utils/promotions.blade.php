@php
    $manage = $manage ?? false;
    $target = $manage ? '_self' : '_blank';
@endphp
<article id="promotions" class="d-flex justify-content-around flex-wrap">
    @if ($promotions->isEmpty())
        <p class="alert alert-warning w-75 mx-auto" role="alert">
            Nenhuma oferta encontrada!
        </p>
    @else
    @foreach ($promotions as $promotion)
        <div class="promotion card col-lg-3-5 col-md-5 col-sm-10 col-12 mb-5" id="promotion-{{ $promotion->id }}">
            @if (!$manage)
                <div class="card-header p-2">
                    <button class="border-0 igs"><i class="fab fa-instagram"></i></button>
                    <button class="border-0 wpp"><i class="fab fa-whatsapp"></i></button>
                    <button class="border-0 tlg"><i class="fab fa-telegram-plane"></i></button>
                    <button class="border-0 twt"><i class="fa-brands fa-x-twitter"></i></button>
                    <button class="border-0 cpy pls plus-share"><i class="fas fa-copy"></i></button>
                    <button class="border-0 mre pls d-none plus-share"><i class="fas fa-share-alt"></i></button>
                </div>
            @endif
            <div class="card-body p-3 text-center">
                <img src="{{ $promotion->image }}" alt="{{ $promotion->title}}" class="product-image mb-3"/><br/>
                <h4 class="card-title">
                    <a
                        target="{{ $target }}"
                        href="{{ $promotion->link }}"
                        class="text-decoration-none link-dark product-title"
                    >
                        {{ $promotion->title }}
                    </a>
                </h4>
                @if (!empty($promotion->was) && ($promotion->was-$promotion->for)>=0.01)
                    <div class="mb-0 col-auto d-flex justify-content-center">
                        De:&nbsp;
                        <div class="text-decoration-line-through price-from">
                            R${{ number_format($promotion->was, 2, ',', '.') }}
                        </div>
                    </div>
                @endif
                <h5 class="pricing-card-title mt-3">
                    {{ ($promotion->for != 0) ? 'R$' . number_format($promotion->for, 2, ',', '.') : 'Grátis' }}
                </h5>
                <p class="installment text-muted">
                    @if ($promotion->times !==1 && $promotion->times !== NULL)
                        {{ $promotion->times }}x
                        {{ (($promotion->installments * $promotion->times) <= $promotion->for + 0.05) ? 'sem juros' : ''; }}
                        de R${{ number_format($promotion->installments, 2, ',', '.') }}
                    @elseif ($promotion->for > 0)
                        Apenas à vista!
                    @endif
                </p>
                @if (!empty($promotion->description))
                    <p class="description">{!! $promotion->description !!}</p>
                @endif
                @if (!empty($promotion->code))
                    <div class="code row col-11 mx-auto">
                        <input value="{{ $promotion->code }}" disabled class="form-control text-center code-text"/>
                    </div>
                @endif
            </div>
            <div class="card-end text-center p-3">
                <div class="text-end">
                    <a target="{{ $target }}" href="{{ $promotion->store->link }}">
                        <img src="{{ $promotion->store->image }}" alt="{{ $promotion->store->name }}" class="store-badge"/>
                    </a>
                </div>
                @if ($manage)
                    <a target="{{ $target }}" href="{{ route('promotions.edit', $promotion->id) }}" class="mx-auto">
                        <button class="btn btn-outline-danger w-75">Editar promoção</button>
                    </a>
                @elseif (empty($promotion->code))
                    <a target="{{ $target }}" href="{{ $promotion->link }}" class="mx-auto">
                        <button class="btn btn-outline-danger w-75">Ir para a loja</button>
                    </a>
                @else
                    <button data-link="{{ $promotion->link }}" class="btn btn-outline-danger w-75 mx-auto copy-redirect">
                        Copiar e ir para a loja
                    </button>
                @endif
            </div>
        </div>
        @endforeach
        <div class="container">
            {{ $promotions->onEachSide(0)->links() }}
        </div>
        @if ($promotions->count() > 3)
            <div class="container text-center flex-column fs-12 bolder top" id="btn-topo">
                <button class="rounded bg-primary px-3 py-2 border-0">
                    <i class="fas fa-angle-double-up text-white"></i>
                </button>
                <p class="fs-5 my-2 fw-light">
                    Topo
                </p>
            </div>
        @endif
        <div class="container text-center text-muted">
            *Ofertas válidas enquanto durarem os estoques e sujeitas a disponibilidade do lote de cupons!
        </div>
    @endif
</article>
