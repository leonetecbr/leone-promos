@extends('layouts.app')
@section('title', 'Método não permitido')
@section('content')
<article class="container">
  <div class="center">
    <p><i class="fas fa-ban erro fs-20"></i></p>
    <h1 class="h2">Método não permitido!</h1>
  </div>
  <div class="mt-5 m-auto w500">
    <p>Desculpe! Essa página está disponível, mas não por esse método!</p>
    <p>Você pode tentar: </p>
    <ul class="fs-12">
      <li>Navegar apenas pelos links e formulários do site</li>
      <li>Limpar o cache do seu navegador</li>
      <li>Verificar a URL acessada</li>
    </ul>
  </div>
</article>
@endsection