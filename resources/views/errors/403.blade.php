@extends('layouts.app')
@section('title', 'Proibido')
@section('content')
<article class="container fs-5">
  <div class="text-center">
    <div><i class="fas fa-ban text-danger fs-1"></i></div>
    <h1>Proibido</h1>
  </div>
  <div class="mt-5">
    <p>Desculpe! Essa página não está disponível para você!</p>
    <p>Possíveis causas: </p>
    <ul>
      <li>Você acessou um diretório privado</li>
      <li>Você forneceu credenciais inválidas para acessar essa página</li>
      <li>Você errou a URL</li>
    </ul>
  </div>
</article>
@endsection
<?php $robots = 'noindex'; ?>