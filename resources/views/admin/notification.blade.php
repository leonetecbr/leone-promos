@extends('layouts.app')
@section('title', 'Nova notificação')
@section('content')
  <article class="container">
  <h1 class="h2 mb-3">Nova notificação</h1>
  @if ($errors->any())
    <div class="alert erro center">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
  @endif
  @if (session('sender'))
    <div class="center alert text-green">
      <p>{{ session('sender') }}</p>
    </div>
  @endif
  <form action="/admin/notify/send" class="container flex-column" method="post" autocomplete="off">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"/>
    <div><label for="name">Título: </label><input type="text"  id="name" name="title" class="bg-white radius" required placeholder="Digite o título da notificação ..."/></div>
    <div class="mt-2"><label for="image">Imagem: </label><input type="text" id="image" name="image" class="bg-white radius" placeholder="Digite o link da imagem. Ex: /img/icon.png ..."/></div>
    <div class="mt-2"><label for="link">Link: </label><input type="text" id="link" name="link" class="bg-white radius" required placeholder="Digite o link. Ex: /admin ..."/></div>
    <div class="mt-2">
      <label for="content">Conteúdo: </label><textarea name="content" id="content" class="radius" placeholder="Digite o conteúdo da notificação ..." required></textarea>
    </div>
    <div class="mt-3">
      <label for="para" class="bolder">Para:
        </label><input type="number" name="para2" id="para" class="bg-white radius" placeholder="Digite o id do destinatário ..." required>
        <div class="container flex-row flex-center row-wrap mt-3" id="prefers">
          <div><input type="checkbox" name="para" id="all" class="prefer"><label for="para">Todos</label></div>
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
    </div>
    <button type="submit" class="mt-2 btn-static padding bg-gradiente m-auto radius">Enviar</button>
    <a href="/admin" class="center"><button type="button" class="mt-2 btn-static padding bg-red flex-center radius">Cancelar</button></a>
  </form>
  </article>
@endsection