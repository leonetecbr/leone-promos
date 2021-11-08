@extends('layouts.app')
@section('title', $title)
@section('content')
<article class="container">
  <h1 class="display-5 text-center mb-3">{{ $title }}</h1>
  @if ($errors->any())
  @foreach ($errors->all() as $error)
  <div class="alert alert-danger text-center mb-3">{{ $error }}</div>
  @endforeach
  @endif
  <form action="/admin/promos/save" class="p-3 flex-column" method="post" autocomplete="off">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
    <div class="row col-lg-9 mx-auto"><div class="col-auto"><label for="name">Título: </label></div><div class="col-auto col-lg-9"><input type="text" value="{{ $promo['nome']??'' }}" id="name" name="name" class="form-control" required placeholder="Digite o título da promoção ..."/></div></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="link">Link: </label></div><div class="col-auto col-lg-9"><input type="text" value="{{ $promo['link']??'' }}" id="link" name="link" class="form-control" required placeholder="Digite o link de afiliados da promoção ..."/></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="thumbnail">Imagem: </label></div><div class="col-auto col-lg-9"><input type="text" value="{{ $promo['imagem']??'' }}" id="thumbnail" name="thumbnail" class="form-control" required placeholder="Digite a URL da imagem..."/></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="priceFrom">De: </label></div><div class="col-auto col-lg-9"><input type="number" value="{{ $promo['de']??'' }}" id="priceFrom" name="priceFrom" class="form-control" step="0.01" min="0.01" placeholder="Digite o preço anterior ..."/></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="price">Por: </label></div><div class="col-auto col-lg-9"><input type="number" value="{{ $promo['por']??'' }}" id="price" name="price" class="form-control" required step="0.01" min="0" placeholder="Digite o preço atual ..."/></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="installment_quantity">Parcelas: </label></div><div class="col-auto col-lg-9"><input type="number" value="{{ $promo['vezes']??'' }}" id="installment_quantity" name="installment_quantity" class="form-control" min="1" max="48" placeholder="Digite a quantidade máxima de parcelas ..."/></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="installment_value">Valor: </label></div><div class="col-auto col-lg-9"><input type="number" value="{{ $promo['parcelas']??'' }}" id="installment_value" name="installment_value" class="form-control" step="0.01" min="0" placeholder="Digite o valor de cada parcela ..."/></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="code">Cupom: </label></div><div class="col-auto col-lg-9"><input type="text" value="{{ $promo['code']??'' }}" id="code" name="code" class="form-control" placeholder="Digite o cupom ..."/></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="description">Descrição: </label></div><div class="col-auto col-lg-9"><textarea name="description" id="description" class="form-control" placeholder="Digite a descrição da promoção ...">{{ $promo['desc']??'' }}</textarea></div></div>
    <div class="row col-lg-9 mx-auto mt-3"><div class="col-auto"><label for="store-id">Loja: </label></div><div class="col-auto col-lg-9"><input type="number" value="{{ $promo['store_id']??'' }}" id="store-id" name="store_id" placeholder="Digite o id da loja ..." class="form-control" required /></div></div>
    <div class="row mt-3">
      <div class="{{ (isset($id))?'col-4':'col-6'; }}"><button type="submit" class="btn btn-primary text-light btn-lg w-100">Salvar</button></div>
      <div class="{{ (isset($id))?'col-4':'col-6'; }}"><a href="/admin/promos" class="center"><button type="button" class="btn btn-danger btn-lg w-100">Cancelar</button></a></div>
      @if (isset($id))
      <div class="col-4">
      <input type="hidden" name="id" value="{{ $promo['id'] }}" />
      <a href="/admin/promos/delete/{{ $promo['id'] }}" class="center"><button type="button" class="btn btn-dark btn-lg w-100">Excluir</button></a>
      </div>
      @endif
    </div>
  </form>
</article>
@endsection