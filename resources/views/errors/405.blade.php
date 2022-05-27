@extends('layouts.app')
@section('title', 'Método não permitido')
@section('content')
    <article class="container fs-5">
        <div class="text-center">
            <div><i class="fas fa-ban text-danger fs-1"></i></div>
            <h1>Método não permitido!</h1>
        </div>
        <div class="mt-5">
            <p>Desculpe! Essa página está disponível, mas não por esse método!</p>
            <p>Você pode tentar: </p>
            <ul>
                <li>Navegar apenas pelos links e formulários do site</li>
                <li>Limpar o cache do seu navegador</li>
                <li>Verificar a URL acessada</li>
            </ul>
        </div>
    </article>
@endsection
<?php $robots = 'noindex'; ?>