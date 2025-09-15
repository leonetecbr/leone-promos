@extends('layouts.app')
@section('title', 'Lojas')
@section('keywords', 'Magalu, Girafa, Positivo, Brastemp, Itatiaia, Brandili, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Aproveite as melhores ofertas das melhores lojas da internet para você comprar com segurança!')
@section('content')
    <h1 class="display-5 text-center">Principais lojas parceiras</h1>
    <article id="stores" class="d-flex container flex-wrap container justify-content-center mt-4">
        @if ($stores->isEmpty())
            <div class="alert alert-danger container" role="alert">
                Nenhuma loja encontrada!
            </div>
        @endif
        @foreach($stores as $store)
            <a href="{{ route('loja', $store->slug) }}">
                <div class="store">
                    <span class="fs-3 fw-light">
                         <img src="{{ $store->image }}" alt="{{ $store->name }}" class="icon"/>
                    </span>
                </div>
            </a>
        @endforeach
    </article>
@endsection
