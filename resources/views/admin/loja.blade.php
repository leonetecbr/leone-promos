@extends('layouts.app')
@section('title', 'Nova loja')
@section('content')
<article class="container">
  <h1 class="display-5 text-center mb-3">Nova loja</h1>
  @if ($errors->any())
  @foreach ($errors->all() as $error)
  <div class="alert alert-danger text-center mb-3">{{ $error }}</div>
  @endforeach
  @endif
  <form action="{{ route('promos.save') }}" class="p-3 flex-column" method="post" autocomplete="off">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
    <div class="row mx-auto">
      <div class="col-auto">
        <label for="id">ID: </label>
      </div>
      <div class="col-12 col-md-10 col-md-11">
        <input type="number" value="{{ $loja['id']??'' }}" id="id" name="id" class="form-control" required placeholder="Digite o id da loja ..." min="1"/>
      </div>
    </div>
    <div class="row mx-auto mt-3">
      <div class="col-auto">
        <label for="name">Nome: </label>
      </div>
      <div class="col-12 col-md-10 col-md-11">
        <input type="text" value="{{ $loja['nome']??'' }}" id="name" name="name" class="form-control" required placeholder="Digite o nome da loja ..."/>
      </div>
    </div>
    <div class="row mx-auto mt-3">
      <div class="col-auto">
        <label for="imagem">Imagem: </label>
      </div>
      <div class="col-12 col-md-10 col-md-11">
        <input type="text" value="{{ $loja['imagem']??'' }}" id="imagem" name="imagem" class="form-control" required placeholder="Digite o link da imagem da loja ..."/>
      </div>
    </div>
        <div class="row mx-auto mt-3">
      <div class="col-auto">
        <label for="link">Link: </label>
      </div>
      <div class="col-12 col-md-10 col-md-11">
        <input type="text" value="{{ $loja['link']??'' }}" id="link" name="link" class="form-control" required placeholder="Digite o link da página inicial loja ..."/>
      </div>
    </div>
    <div class="text-end mt-3">
      <input type="checkbox" name="redirect" id="redirect" {{ $loja['redirect']??'checked' }} class="form-check-input"/> Link de afiliados
    </div>
    <div class="row mt-3">
      <div class="col-sm-6"><button type="submit" class="btn btn-primary text-light btn-lg w-100">Salvar</button></div>
      <div class="my-3 my-sm-0 col-sm-6"><a href="{{ route('promos.list') }}" class="center"><button type="button" class="btn btn-danger btn-lg w-100">Cancelar</button></a></div>
    </div>
  </form>
</article>
@endsection