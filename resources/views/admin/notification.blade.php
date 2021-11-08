@extends('layouts.app')
@section('title', 'Nova notificação')
@section('content')
<article class="container">
  <h1 class="text-center display-5 mb-4">Nova notificação</h1>
  @if ($errors->any())
  @foreach ($errors->all() as $error)
  <div class="alert alert-danger text-center mb-3">{{ $error }}</div>
  @endforeach
  @endif
  @if (session('sender'))
  <div class="text-center alert alert-success mb-3">
    {{ session('sender') }}
  </div>
  @endif
  <form action="/admin/notify/send" class="p3 px-lg-5 flex-column" method="post" autocomplete="off">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
    <div class="row"><div class="col-auto"><label for="name" class="col-auto">Título: </label></div><div class="col-8"><input type="text" id="name" name="title" class="form-control" required placeholder="Digite o título da notificação ..." /></div></div>
    <div class="row mt-3"><div class="col-auto"><label for="image">Imagem: </label></div><div class="col-8"><input type="text" id="image" name="image" class="form-control" placeholder="Digite o link da imagem. Ex: /img/icon.png ..." /></div></div>
    <div class="row mt-3"><div class="col-auto"><label for="link">Link: </label></div><div class="col-8"><input type="text" id="link" name="link" class="form-control" required placeholder="Digite o link. Ex: /admin ..." /></div></div>
    <div class="form-group mt-3">
      <label for="content" class="mb-2">Conteúdo: </label><textarea name="content" id="content" class="form-control" placeholder="Digite o conteúdo da notificação ..." required></textarea>
    </div>
    <div class="mt-3">
      <div class="row mb-3">
        <div class="col-auto"><label for="para">Para:</label></div>
        <div class="col-8">
          <input type="number" name="para2" id="para" class="form-control" placeholder="Digite o id do destinatário ..." required>
        </div>
      </div>
      <div class="container flex-row flex-center row-wrap d-md-flex justify-conatent-center flex-wrap" id="prefers">
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="para" id="all" class="form-check-input"><label for="all" class="form-check-label">Todos</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p1" id="p1" class="form-check-input prefer"> <label for="p1" class="form-check-label">Computadores/Notebooks</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p2" id="p2" class="form-check-input prefer"> <label for="p2" class="form-check-label">Celulares/Smartphones</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p3" id="p3" class="form-check-input prefer"> <label for="p3" class="form-check-label">Itens de Mercado</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p4" id="p4" class="form-check-input prefer"> <label for="p4" class="form-check-label">Roupas Masculinas</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p5" id="p5" class="form-check-input prefer"> <label for="p5" class="form-check-label">Roupas Femininas</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p6" id="p6" class="form-check-input prefer"> <label for="p6" class="form-check-label">Livros</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p7" id="p7" class="form-check-input prefer"> <label for="p7" class="form-check-label">Móveis</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p8" id="p8" class="form-check-input prefer"> <label for="p8" class="form-check-label">Eletrodomésticos</label></div>
        <div class="form-check col-md-6 col-lg-4"><input type="checkbox" name="p9" id="p9" class="form-check-input prefer"> <label for="p9" class="form-check-label">Eletroportáteis</label></div>
      </div>
    </div>
    <div class="row justify-content-around mt-4">
      <button type="submit" class="btn btn-primary text-light col-5 btn-lg">Enviar</button>
      <a href="/admin" class="col-5"><button type="button" class="btn btn-danger w-100 btn-lg">Cancelar</button></a>
    </>
  </form>
</article>
@endsection