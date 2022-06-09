@extends('layouts.app')
@section('title', 'Administração')
@section('content')
    <article class="container">
        <h1 class="display-5 text-center">Administração</h1>
        <div class="list d-flex mt-4 flex-wrap mx-auto justify-content-around">
            <div class="border p-3 col-12 col-lg-5">
                <a href="{{ route('promos.list') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3>Melhores pomoções</h3>
                    <p class="mt-3">Vizualize, criei e edite a seleção de melhores promoções.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4 mt-lg-0">
                <a href="{{ route('lojas.new') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3>Nova loja</h3>
                    <p class="mt-3">Cadastre uma loja nova nova no sistema.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('notification.new') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3>Nova notificação</h3>
                    <p class="mt-3">Envie notificações para um usuário específico, para todos usuário ou para um grupo específico.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('notification.history') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3>Histórico de notificações</h3>
                    <p class="mt-3">Consulte o histórico de notificações enviadas pelo sitema, APIs ou painel de administração.</p>
                </a>
            </div>
        </div>
    </article>
@endsection