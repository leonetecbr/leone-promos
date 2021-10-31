@extends('layouts.app')
@section('title', 'Proibido')
@section('content')
<article class="container">
  <div class="center">
    <p><i class="fas fa-clock fs-20 text-orange"></i></p>
    <h1 class="h2">Página expirada</h1>
  </div>
  <div class="mt-5 m-auto w500">
    <p>Desculpe! Essa página não poderá ser acessada!</p>
    <p>Possíveis causas: </p>
    <ul class="fs-12">
      <li>Você demorou muito na página anterior</li>
      <li>Você está recarregando uma página que recebeu dados</li>
      <li>Você está tentando acessar uma área que não deveria</li>
    </ul>
    <p>Volte para página anterior, atualize-a e tente novamente.</p>
  </div>
</article>
@endsection
<?php $robots = 'noindex'; ?>