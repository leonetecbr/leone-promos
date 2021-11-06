@extends('layouts.app')
@section('title', 'Categorias')
@section('keywords', 'Smartphone, Informática, Tv, Geladeira, PC, Fogão, máquina de lavar, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Aproveite as melhores ofertas de várias categorias de produtos em várias lojas da internet para você comprar com segurança!')
@section('content')
<h1 class="display-5 text-center">Categorias</h1>
<article id="categorias" class="d-flex container flex-wrap container justify-content-center mt-4">
  <div class="categoria">
    <a href="{{ route('categoria', 'smartphones') }}">
      <span class="fs-3 fw-light"><i class="fa-solid fa-mobile-button"></i><br>Smartphones</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'informatica') }}">
      <span class="fs-3 fw-light"><i class="fas fa-laptop"></i><br>Informática</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'eletronicos') }}">
      <span class="fs-3 fw-light"><i class="fas fa-headphones"></i><br>Eletrônicos</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'eletrodomesticos') }}">
      <span class="fs-3 fw-light"><i class="fas fa-blender"></i><br>Eletrodomésticos</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'pc') }}">
      <span class="fs-3 fw-light"><i class="fas fa-desktop"></i><br>PCs</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'bonecas') }}">
      <span class="fs-3 fw-light"><i class="fas fa-child"></i><br>Bonecas</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'tv') }}">
      <span class="fs-3 fw-light"><i class="fas fa-tv"></i><br>TVs</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'fogao') }}">
      <span class="fs-3 fw-light"><i class="fas fa-fire"></i><br>Fogão</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'geladeira') }}">
      <span class="fs-3 fw-light"><i class="fas fa-temperature-low"></i><br>Geladeira</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'lavaroupas') }}">
      <span class="fs-3 fw-light"><i class="fas fa-tshirt"></i><br>Lava-roupas</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'roupasm') }}">
      <span class="fs-3 fw-light"><i class="fas fa-male"></i> Roupas Masculinas</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'roupasf') }}">
      <span class="fs-3 fw-light"><i class="fas fa-female"></i> Roupas Femininas</span>
        </div>
    </a>
  <div class="categoria">
    <a href="{{ route('categoria', 'talheres') }}">
      <span class="fs-3 fw-light"><i class="fas fa-utensils"></i><br>Talheres</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'camas') }}">
      <span class="fs-3 fw-light"><i class="fas fa-bed"></i><br>Camas</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'casaedeco') }}">
      <span class="fs-3 fw-light"><i class="fas fa-home"></i> Casa e decoração</span>
    </a>
  </div>
  <div class="categoria">
    <a href="{{ route('categoria', 'mesas') }}">
      <span class="fs-3 fw-light"><i class="fas fa-chair"></i><br>Mesas</span>
    </a>
  </div>
</article>
@endsection