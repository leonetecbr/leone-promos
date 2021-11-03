@extends('layouts.app')
@section('title', 'Lojas')
@section('keywords', 'Americanas, Magalu, Girafa, Positivo, Brastemp, Itatiaia, Shoptime, Brandili, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Aproveite as melhores ofertas das melhores lojas da internet para você comprar com segurança!')
@section('content')
<h1 class="display-5 text-center">Principais lojas parceiras</h1>
<article id="categorias" class="d-flex container flex-wrap container justify-content-center mt-4">
    <div class="categoria">
      <a href="{{ route('loja', 'americanas') }}">
        <img src="https://www.lomadee.com/programas/BR/5632/logo_185x140.png" alt="Americanas" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'submarino') }}">
        <img src="https://www.lomadee.com/programas/BR/5766/logo_115x76.png" alt="Submarino" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'magalu') }}">
        <img src="https://mvc.mlcdn.com.br/magazinevoce/img/common/parceiro-magalu-logo-blue.svg" alt="Parceiro Magalu" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'shoptime') }}">
        <img src="https://www.lomadee.com/programas/BR/5644/logo_115x76.png" alt="Shoptime" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'brandili') }}">
        <img src="https://www.lomadee.com/programas/BR/7863/logo_115x76.png" alt="Brandili" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'usaflex') }}">
        <img src="https://www.lomadee.com/programas/BR/6358/logo_115x76.png" alt="Usaflex" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'electrolux') }}">
        <img src="https://www.lomadee.com/programas/BR/6078/logo_115x76.png" alt="Electrolux" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'itatiaia') }}">
        <img src="https://www.lomadee.com/programas/BR/7460/logo_115x76.png" alt="Itatiaia" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'brastemp') }}">
        <img src="https://www.lomadee.com/programas/BR/5936/logo_115x76.png" alt="Brastemp" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'positivo') }}">
        <img src="https://www.lomadee.com/programas/BR/6117/logo_115x76.png" alt="Positivo" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'etna') }}">
        <img src="https://www.lomadee.com/programas/BR/6373/logo_115x76.png" alt="Etna" class="icon" />
      </a>
    </div>
    <div class="categoria">
      <a href="{{ route('loja', 'repassa') }}">
        <img src="https://www.lomadee.com/programas/BR/6104/logo_115x76.png" alt="Repassa" class="icon" />
      </a>
    </div>
</article>
@endsection