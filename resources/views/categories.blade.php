@extends('layouts.app')
@section('title', 'Categorias')
@section('keywords', 'Smartphone, Informática, Tv, Geladeira, PC, Fogão, máquina de lavar, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Aproveite as melhores ofertas de várias categorias de produtos em várias lojas da internet para você comprar com segurança!')
@section('content')
    <h1 class="display-5 text-center">Categorias</h1>
    <article id="categories" class="d-flex container flex-wrap container justify-content-center mt-4">
        @if ($categories->isEmpty())
            <div class="alert alert-danger container" role="alert">
                Nenhuma categoria encontrada!
            </div>
        @endif
        @foreach($categories as $category)
            <div class="category">
                <a href="{{ route('categoria', $category->slug) }}">
                <span class="fs-3 fw-light">
                    <i class="fa-solid fa-{{ $category->icon }}"></i>
                    @if (mb_strwidth($category->name) > 15) <br/> @endif
                    {{ ($category->name) }}
                </span>
                </a>
            </div>
        @endforeach
    </article>
@endsection
