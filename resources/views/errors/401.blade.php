@extends('layouts.app')
@section('title', 'Não autorizado')
@section('content')
<article class="container">
  <div class="center">
    <p><i class="fas fa-lock fs-20 text-orange"></i></p>
    <h1 class="h2">Não autorizado</h1>
  </div>
  <div class="mt-5 m-auto w500">
    <p>Desculpe! Essa página exige algum tipo de autenticação que não foi feita.</p>
    <p>Possíveis causas: </p>
    <ul class="fs-12">
      <li>Você acessou um diretório privado</li>
      <li>Sua rede passou por instabilidades e os dados não foram passados</li>
      <li>Você errou a URL</li>
    </ul>
</div>
</article>
@endsection