@extends('layouts.app')
@section('title', 'Não autorizado')
@section('content')
<article class="container fs-5">
  <div class="text-center">
    <div><i class="fas fa-lock text-primary fs-1"></i></div>
    <h1 class="h2">Não autorizado</h1>
  </div>
  <div class="mt-5">
    <p>Desculpe! Essa página exige algum tipo de autenticação que não foi feita.</p>
    <p>Possíveis causas: </p>
    <ul>
      <li>Você acessou um diretório privado</li>
      <li>Sua rede passou por instabilidades e os dados não foram passados</li>
      <li>Você errou a URL</li>
    </ul>
  </div>
</article>
@endsection
<?php $robots = 'noindex'; ?>