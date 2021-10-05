@extends('layouts.app')
@section('title', 'Não encontrado')
@section('content')
<article class="container">
<div class="center">
 <p><i class="far fa-question-circle fs-20 erro"></i></p>
  <h2 class="h2">Página não encontrada!</h2>
</div>
<p>Desculpe! Essa página nunca existiu ou foi excluída!</p>
<p>Você pode tentar: </p>
<ul class="fs-12">
  <li>Navegar apenas pelos links e menus do site</li>
  <li>Limpar o cache do seu navegador</li>
  <li>Verificar a URL acessada</li>
</ul>
</article>
@endsection