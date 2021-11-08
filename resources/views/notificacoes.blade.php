@extends('layouts.app')
@section('title', 'Notificações')
@section('keywords', ', promoção, menor preço, ofertas, promoções, oferta, notificações, aviso, alerta')
@section('description', 'Ative nossas notificações, edite suas preferências e não perca nenhuma promoção imperdível.')
@section('content')
<article class="container">
  <h1 class="display-5">Gerenciar notificações</h1>
  <div id="notifys">
   <p class="my-3">Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador! Aqui você pode ativar, desativar e gerenciar suas preferências de notificação.</p>
    <div class="text-center mb-3"><button id="btn-notify" class="btn btn-primary text-light" disabled="true">Ativar notificações</button></div></div>
    <div id="preferencias" class="d-none mt-3">
      <h2 class="display-6">Peferências</h2>
      <p>Você deseja ser notificado sempre que houver promoção de: </p>
      <div class="text-center mb-3 d-none" id="error_pref-form"></div>
      <form action="/prefer/set" method="post" class="ajax_form container" id="pref-form">
        <div class="container flex-row flex-center row-wrap d-md-flex justify-conatent-center flex-wrap" id="prefers">
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p0" id="all" class="form-check-input"> <label for="all" class="form-check-label" >Tudo</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p1" id="p1" class="form-check-input prefer"> <label class="form-check-label" for="p1">Computadores/Notebooks</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p2" id="p2" class="form-check-input prefer"> <label for="p2" class="form-check-label" >Celulares/Smartphones</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p3" id="p3" class="form-check-input prefer"> <label for="p3" class="form-check-label" >Itens de Mercado</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p4" id="p4" class="form-check-input prefer"> <label for="p4" class="form-check-label" >Roupas Masculinas</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p5" id="p5" class="form-check-input prefer"> <label for="p5" class="form-check-label" >Roupas Femininas</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p6" id="p6" class="form-check-input prefer"> <label for="p6" class="form-check-label" >Livros</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p7" id="p7" class="form-check-input prefer"> <label for="p7" class="form-check-label" >Móveis</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p8" id="p8" class="form-check-input prefer"> <label for="p8" class="form-check-label" >Eletrodomésticos</label></div>
          <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p9" id="p9" class="form-check-input prefer"> <label for="p9" class="form-check-label" >Eletroportáteis</label></div>
        </div>
        <input type="hidden" name="endpoint" id="endpoint">
        <div class="text-center"><button class="btn btn-primary text-light mt-3" type="submit" id="pref-form_submit">Salvar</button></div>
      </form>
    </div>
  </div>
</article>
@endsection