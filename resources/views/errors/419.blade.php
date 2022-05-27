@extends('layouts.app')
@section('title', 'Expirado')
@section('content')
    <article class="container fs-5">
        <div class="center text-center">
            <div><i class="fas fa-clock fs-1 text-primary"></i></div>
            <h1>Página expirada</h1>
        </div>
        <div class="mt-5">
            <p>Desculpe! Essa página não poderá ser acessada!</p>
            <p>Possíveis causas: </p>
            <ul>
                <li>Você demorou muito na página anterior</li>
                <li>Você está recarregando uma página que recebeu dados</li>
                <li>Você está tentando acessar uma área que não deveria</li>
            </ul>
            <p>Volte para página anterior, atualize-a e tente novamente.</p>
        </div>
    </article>
@endsection
<?php $robots = 'noindex'; ?>
