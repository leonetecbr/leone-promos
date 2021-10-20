@extends('layouts.app')
@section('title', 'Notificações')
@section('content')
<article class="container">
<h1 id="title" class="container">Gerenciar notificações</h1>
<div id="notifys" class="container">
<p>Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador!</p><br />
<div class="center mb-2"><button id="btn-notify" class="btn-static bg-orange radius" disabled="true">Ativar notificações</button></div>
</div>
<div id="preferencias" class="hidden mt-3">
    <h2 class="h2 container">Peferências</h2>
    <p class="container">Você deseja ser notificado sempre que houver promoção de: </p>
    <div class="container center mb-2 hidden" id="error_pref-form"></div>
    <form action="/prefer/set" method="post" class="ajax_form container" id="pref-form">
        <div class="container flex-row flex-center row-wrap " id="prefers">
            <div><input type="checkbox" name="p0" id="all" class="prefer"> <label for="all">Tudo</label></div>
            <div><input type="checkbox" name="p1" id="p1"class="prefer"> <label for="p1">Computadores/Notebooks</label></div>
            <div><input type="checkbox" name="p2" id="p2" class="prefer"> <label for="p2">Celulares/Smartphones</label></div>
            <div><input type="checkbox" name="p3" id="p3" class="prefer"> <label for="p3">Itens de Mercado</label></div>
            <div><input type="checkbox" name="p4" id="p4" class="prefer"> <label for="p4">Roupas Masculinas</label></div>
            <div><input type="checkbox" name="p5" id="p5" class="prefer"> <label for="p5">Roupas Femininas</label></div>
            <div><input type="checkbox" name="p6" id="p6" class="prefer"> <label for="p6">Livros</label></div>
            <div><input type="checkbox" name="p7" id="p7" class="prefer"> <label for="p7">Móveis</label></div>
            <div><input type="checkbox" name="p8" id="p8" class="prefer"> <label for="p8">Eletrodomésticos</label></div>
            <div><input type="checkbox" name="p9" id="p9" class="prefer"> <label for="p9">Eletroportáteis</label></div>
        </div>
        <input type="hidden" name="endpoint" id="endpoint">
        <div class="center"><button class="btn-static bg-orange radius mb-3" type="submit" id="pref-form_submit">Salvar</button></div>
    </form>
</div>
</article>
@endsection