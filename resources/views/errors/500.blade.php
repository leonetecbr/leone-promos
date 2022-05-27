@extends('layouts.app')
@section('title', 'Erro interno')
@section('content')
    <article class="container fs-5">
        <div class="text-center">
            <div><i class="fas fa-exclamation-triangle text-danger fs-1"></i></div>
            <h1>Erro interno no servidor</h1>
        </div>
        <div class="mt-5">
            <p>Desculpe! Foi encontrado um erro no servidor e sua solicitação não pode ser atendida.</p>
            <p>Possíveis causas: </p>
            <ul>
                <li>Estamos com tráfego mais intenso que o habitual</li>
                <li>Houve um erro na codificação do sistema</li>
                <li>Nosso servidor está enfrentando problemas técnicos</li>
            </ul>
            <p>Seja qual for a causa saiba que já fomos notificados estamos trabalhando para resolver o mais rápido possível.</p>
        </div>
    </article>
@endsection
<?php $robots = 'noindex'; ?>