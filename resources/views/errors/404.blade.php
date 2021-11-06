@extends('layouts.app')
@section('title', 'Não encontrado')
@section('content')
<article class="container fs-5">
  <div class="text-center">
    <div><i class="far fa-question-circle text-warning fs-1"></i></div>
    <h1 class="display5 text-center">Página não encontrada!</h1>
  </div>
  <div class="mt-5">
    <p>Desculpe! Essa página nunca existiu ou foi excluída!</p>
    <p>Você pode tentar: </p>
    <ul>
      <li>Navegar apenas pelos links e menus do site</li>
      <li>Limpar o cache do seu navegador</li>
      <li>Verificar a URL acessada</li>
    </ul>
  </div>
</article>
@endsection
<?php $robots = 'noindex'; ?>