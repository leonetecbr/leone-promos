@extends('layouts.app')
@section('title', 'Erro interno')
@section('content')
<article class="container">
<div class="center">
  <p><i class="fas fa-exclamation-triangle fs-20 erro"></i></p>
  <h2 class="h2">Erro interno no servidor</h2>
</div>
<p>Desculpe! Foi encontrado um erro no servidor e sua solicitação não pode ser atendida.</p>
<p>Possíveis causas: </p>
<ul class="fs-12">
  <li>Estamos com tráfego mais intenso que o habitual</li>
  <li>Houve um erro na codificação do sistema</li>
  <li>Nosso servidor está enfrentando problemas técnicos</li>
</ul>
<p>Seja qual for a causa saiba que já fomos notificados estamos trabalhando  para resolver o mais rápido possível.</p>
</article>
@endsection