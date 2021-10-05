@extends('layouts.app')
@section('title', 'Notificações')
@section('content')
<article class="container">
<h2 id="title" class="container">Gerenciar notificações</h2>
<div id="notifys" class="container">
<p>Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador!</p><br />
<div class="center"><button id="btn-notify" class="btn-static bg-orange radius" disabled="true">Ativar notificações</button></div>
</div>
<p class="container">Em breve você também poderá editar suas preferências aqui!</p>
</article>
@endsection