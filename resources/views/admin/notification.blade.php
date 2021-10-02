@extends('layouts.app')
@section('title', 'Nova notificação')
@section('content')
  <article class="container">
  <h2 class="h2 mb-3">Nova notificação</h2>
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
      <label for="para2" class="bolder">Para:
        </label><input type="number" name="para2" id="para2" class="bg-white radius" placeholder="Digite o id do destinatário ..." required>
      <div class="center mt-1"><input type="checkbox" name="para" id="para"><label for="para">Todos</label></div>
    </div>
    <button type="submit" class="mt-2 btn-static padding bg-gradiente flex-center radius">Enviar</button>
    <a href="/admin"><button type="button" class="mt-2 btn-static padding bg-red flex-center radius">Cancelar</button></a>
  </form>
  </article>
@endsection