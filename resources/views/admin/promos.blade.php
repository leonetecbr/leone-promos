@extends('layouts.app')
@section('title', $title)
@section('content')
  <article class="container">
  <h1 class="h2 mb-3">{{ $title }}</h1>
  @if ($errors->any())
    <div class="alert erro center">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif
  <form action="/admin/promos/save" class="container flex-column" method="post" autocomplete="off">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"/>
    <div><label for="name">Título: </label><input type="text" value="{{ $promo['name']??'' }}" id="name" name="name" class="bg-white radius" required/></div>
    <div class="mt-2"><label for="link">Link: </label><input type="text" value="{{ $promo['link']??'' }}" id="link" name="link" class="bg-white radius" required/></div>
    <div class="mt-2"><label for="thumbnail">Imagem: </label><input type="text" value="{{ $promo['thumbnail']??'' }}" id="thumbnail" name="thumbnail" class="bg-white radius" required/></div>
    <div class="mt-2"><label for="priceFrom">De: </label><input type="number" value="{{ $promo['priceFrom']??'' }}" id="priceFrom" name="priceFrom" class="bg-white radius" step="0.01" min="0.01"/></div>
    <div class="mt-2"><label for="price">Por: </label><input type="number" value="{{ $promo['price']??'' }}" id="price" name="price" class="bg-white radius" required step="0.01" min="0"/></div>
    <div class="mt-2"><label for="discount">Desconto: </label><input type="number" value="{{ $promo['discount']??'' }}" id="discount" name="discount" class="bg-white radius" step="0.01" min="0"/></div>
    <div class="mt-2"><label for="installment_quantity">Parcelas: </label><input type="number" value="{{ $promo['installment']['quantity']??'' }}" id="installment_quantity" name="installment_quantity" class="bg-white radius" min="1" max="48"/></div>
    <div class="mt-2"><label for="installment_value">Valor: </label><input type="number" value="{{ $promo['installment']['value']??'' }}" id="installment_value" name="installment_value" class="bg-white radius" step="0.01" min="0"/></div>
    <div class="mt-2"><label for="code">Cupom: </label><input type="text" value="{{ $promo['code']??'' }}" id="code" name="code" class="bg-white radius"/></div>
    <div class="mt-2">
      <label for="description">Descrição: </label><textarea name="description" id="description" class="radius">{{ $promo['description']??'' }}</textarea>
    </div>
    <div class="mt-2"><label for="store_name">Loja: </label><input type="text" value="{{ $promo['store']['name']??'' }}" id="store_name" name="store_name" class="bg-white radius" required/></div>
    <div class="mt-2"><label for="store_link">Link: </label><input type="text" value="{{ $promo['store']['link']??'' }}" id="store_link" name="store_link" class="bg-white radius" required/></div>
    <div class="mt-2"><label for="store_thumbnail">Imagem: </label><input type="text" value="{{ $promo['store']['thumbnail']??'' }}" id="store_thumbnail" name="store_thumbnail" class="bg-white radius" required/></div>
    <button type="submit" class="mt-2 btn-static padding bg-gradiente m-auto radius">Salvar</button>
    <a href="/admin/promos" class="center"><button type="button" class="mt-2 btn-static padding bg-red flex-center radius">Cancelar</button></a>
    @if (isset($id))
    <input type="hidden" name="id" value="{{ $id }}"/>
    <a href="/admin/promos/delete/{{ $id }}" class="center"><button type="button" class="mt-2 btn-static padding bg-black flex-center radius">Excluir</button></a>
    @endif
  </form>
  </article>
@endsection