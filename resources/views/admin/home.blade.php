@extends('layouts.app')
@section('title', 'Administração')
@section('content')
<article class="container">
  <h1 class="display-5 text-center">Administração</h1>
  <div class="list d-flex mt-4 flex-wrap mx-auto justify-content-around">
    <div class="border p-3 col-12 col-lg-5">
      <a href="/admin/promos" class="text-black text-decoration-none">
        <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
        <h3>Melhores pomoções</h3>
        <p class="mt-3">Vizualize, criei e edite a seleção de melhores promoções.</p>
      </a>
    </div>
    <div class="border p-3 col-12 col-lg-5 mt-4 mt-lg-0">
      <a href="/admin/notify" class="text-black text-decoration-none">
        <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
        <h3>Notificações</h3>
        <p class="mt-3">Envie notificações para um usuário específico ou para todos usuário.</p>
      </a>
    </div>
  </div>
</article>
@endsection