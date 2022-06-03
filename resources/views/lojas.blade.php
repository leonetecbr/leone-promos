@extends('layouts.app')
@section('title', 'Lojas')
@section('keywords', 'Americanas, Magalu, Girafa, Positivo, Brastemp, Itatiaia, Shoptime, Brandili, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Aproveite as melhores ofertas das melhores lojas da internet para você comprar com segurança!')
@section('content')
    <h1 class="display-5 text-center">Principais lojas parceiras</h1>
    <article id="categorias" class="d-flex container flex-wrap container justify-content-center mt-4">
        @if (empty($stores))
            <div class="alert alert-danger container text-center">
                Nenhuma loja encontrada!
            </div>
        @endif
        @foreach($stores as $store)
            <div class="categoria">
                <a href="{{ route('loja', $store['name']) }}">
                <span class="fs-3 fw-light">
                     <img src="{{ $store['image'] }}" alt="{{ $store['title'] }}" class="icon" />
                </span>
                </a>
            </div>
        @endforeach
    </article>
@endsection