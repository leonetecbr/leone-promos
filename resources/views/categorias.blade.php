@extends('layouts.app')
@section('title', 'Categorias')
@section('keywords', 'Smartphone, Informática, Tv, Geladeira, PC, Fogão, máquina de lavar, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Aproveite as melhores ofertas de várias categorias de produtos em várias lojas da internet para você comprar com segurança!')
@section('content')
    <h1 class="display-5 text-center">Categorias</h1>
    <article id="categorias" class="d-flex container flex-wrap container justify-content-center mt-4">
        @if (empty($categories))
            <div class="alert alert-danger container text-center">
                Nenhuma categoria encontrada!
            </div>
        @endif
        @foreach($categories as $category)
        <div class="categoria">
            <a href="{{ route('categoria', $category['name']) }}">
                <span class="fs-3 fw-light">
                    <i class="fa-solid fa-{{ $category['icon'] }}"></i>{!! (strlen($category['title']) > 15)?'<br/>':''; !!}
                    {{ ($category['title']) }}
                </span>
            </a>
        </div>
        @endforeach
    </article>
@endsection