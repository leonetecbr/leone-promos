@extends('layouts.app')
@section('title', 'Administração')
@section('content')
  <article class="container">
  <h2 class="h2">Administração</h2>
  <div class="container list flex-column mt-2">
    <div class="border-1 padding">
      <a href="/admin/promos" class="txt-black"><div class="right"><i class="fas fa-angle-right"></i></div>
      <h3 class="h3">Melhores pomoções</h3>
      <p class="mt-3">Vizualize, criei e edite a seleção de melhores promoções.</p></a>
    </div>
    <div class="border-1 padding mt-3">
      <a href="/admin/notify" class="txt-black"><div class="right"><i class="fas fa-angle-right"></i></div>
      <h3 class="h3">Notificações</h3>
      <p class="mt-3">Envie notificações para um usuário específico ou para todos usuário.</p></a>
    </div>
  </div>
  </article>
@endsection