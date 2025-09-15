@extends('layouts.app')
@section('title', 'Administração')
@section('content')
    <article class="container">
        <h1 class="display-5 text-center">Administração</h1>
        <div class="list d-flex mt-4 flex-wrap mx-auto justify-content-around">
            <div class="border p-3 col-12 col-lg-5">
                <a href="{{ route('promotions.index') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fa-solid fa-bag-shopping"></i> Promoções</h3>
                    <p class="mt-3">Gerencie as promoções cadastradas no site.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4 mt-lg-0">
                <a href="{{ route('promotions.index') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fas fa-tags"></i> Cupons</h3>
                    <p class="mt-3">Gerencie os cupons cadastrados no site.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('promotions.index') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fas fa-list"></i> Categorias</h3>
                    <p class="mt-3">Gerencie as categorias cadastradas no site.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('lojas.new') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fas fa-store"></i> Lojas</h3>
                    <p class="mt-3">Gerencie as categorias cadastradas no site.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('lojas.new') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fas fa-store"></i> Lojas</h3>
                    <p class="mt-3">Gerencie as lojas cadastradas no site.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('notification.new') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fa-solid fa-users"></i> Usuários</h3>
                    <p class="mt-3">Gerencie os usuários cadastrados no site.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('notification.history') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fa-solid fa-bell"></i> Notificações</h3>
                    <p class="mt-3">Visualize as notificações enviadas e envie novas notificações.</p>
                </a>
            </div>
            <div class="border p-3 col-12 col-lg-5 mt-4">
                <a href="{{ route('notification.history') }}" class="text-black text-decoration-none">
                    <div class="float-end mt-4"><i class="fas fa-angle-right"></i></div>
                    <h3><i class="fa-solid fa-cash-register"></i> Vendas</h3>
                    <p class="mt-3">Configure notificações de novas vendas.</p>
                </a>
            </div>
        </div>
    </article>
@endsection
