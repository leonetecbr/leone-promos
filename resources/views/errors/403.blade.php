@extends('layouts.app')
@section('title', 'Proibido')
@section('content')
<article class="container">
<div class="center">
  <p><i class="fas fa-ban fs-20 erro"></i></p>
  <h2 class="h2">Proibido</h2>
</div>
<p>Desculpe! Essa página não está disponível para você!</p>
<p>Possíveis causas: </p>
<ul class="fs-12">
  <li>Você acessou um diretório privado</li>
  <li>Você forneceu credenciais inválidas para acessar essa página</li>
  <li>Você errou a URL</li>
</ul>
</article>
@endsection