@extends('layouts.app')
@section('title', 'Categorias')
@section('keywords', 'Smartphone, Informática, Tv, Geladeira, PC, Fogão, máquina de lavar, promoção, menor preço, ofertas, promoções, oferta')
@section('description', 'Aproveite as melhores ofertas de várias categorias de produtos em várias lojas da internet para você comprar com segurança!')
@section('content')
<h1 class="container" id="title">Categorias</h1>
<article id="categorias" class="container center">
    <a href="/categorias/smartphones">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-mobile"></i> Smartphones</h4>
        </div>
    </a>
    <a href="/categorias/informatica">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-laptop"></i> Informática</h4>
        </div>
    </a>
    <a href="/categorias/eletronicos">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-headphones"></i> Eletrônicos</h4>
        </div>
    </a>
    <a href="/categorias/eletrodomesticos">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-blender"></i> Eletrodomésticos</h4>
        </div>
    </a>
    <a href="/categorias/pc">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-desktop"></i> PCs</h4>
        </div>
    </a>
    <a href="/categorias/bonecas">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-child"></i> Bonecas</h4>
        </div>
    </a>
    <a href="/categorias/tv">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-tv"></i> TVs</h4>
        </div>
    </a>
    <a href="/categorias/fogao">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-fire"></i> Fogão</h4>
        </div>
    </a>
    <a href="/categorias/geladeira">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-temperature-low"></i> Geladeira</h4>
        </div>
    </a>
    <a href="/categorias/lavaroupas">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-tshirt"></i> Máquina de Lavar Roupas</h4>
        </div>
    </a>
    <a href="/categorias/roupasm">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-male"></i> Roupas Masculinas</h4>
        </div>
    </a>
    <a href="/categorias/roupasf">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-female"></i> Roupas Femininas</h4>
        </div>
    </a>
    <a href="/categorias/talheres">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-utensils"></i> Talheres</h4>
        </div>
    </a>
    <a href="/categorias/camas">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-bed"></i> Camas</h4>
        </div>
    </a>
    <a href="/categorias/casaedeco">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-home"></i> Casa e decoração</h4>
        </div>
    </a>
    <a href="/categorias/armario">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-archive"></i> Guarda-roupa</h4>
        </div>
    </a>
    <a href="/categorias/mesas">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-chair"></i> Mesas</h4>
        </div>
    </a>
    <a href="/categorias/luz">
        <div class="categoria bg-white radius">
            <h4><i class="fas fa-lightbulb"></i> Lâmpada</h4>
        </div>
    </a>
</article>
@endsection