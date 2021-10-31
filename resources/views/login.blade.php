@extends('layouts.app')
@section('title', 'Login administrativo')
@section('content')
<article class="container">
  <h1 class="h2">Login administrativo</h1>
  <div id="login" class="container">
    @if ($errors->any())
    <div class="alert erro center">
      @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
      @endforeach
    </div>
    @endif
    <form action="/admin" method="post" class="mt-2 flex-column center">
      <div><label for="email">Email: </label><input type="text" name="email" id="email" class="bg-white radius" placeholder="Digite seu email ..." required @if (session('email')) value="{{ session('email') }}" @endif></div>
      <div class="mt-2"><label for="password">Senha: </label><input type="password" name="password" id="password" class="bg-white radius" placeholder="Digite sua senha ..."></div>
      <div class="g-recaptcha mt-2 flex-center" data-sitekey="{{ $_ENV['PUBLIC_RECAPTCHA_V2'] }}" data-callback="submit"></div>
      <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
      <button type="submit" class="btn-static padding bg-gradiente radius mt-2 m-auto">Logar</button>
    </form>
  </div>
</article>
@endsection
@section('headers')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
<?php $robots = 'noindex'; ?>