@extends('layouts.app')
@section('title', 'Login administrativo')
@section('content')
    <article class="container">
        <h1 class="display-5 mb-4 text-center">Login administrativo</h1>
        <div id="login">
            <form action="{{ route('dashboard') }}" method="post" class="col-12 col-md-8 col-lg-6 col-xl-5 mx-auto mt-2 d-flex flex-column border py-5 px-3">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-center w-100 mb-4 mx-auto">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="row col-lg-9 mx-auto">
                    <div class="col-auto">
                        <label for="email">Email: </label>
                    </div>
                    <div class="col-auto col-lg-9">
                        <input type="text" name="email" id="email" class="form-control" placeholder="Digite seu email ..." required value="{{ old('email') }}">
                    </div>
                </div>
                <div class="row col-lg-9 mx-auto my-4">
                    <div class="col-auto">
                        <label for="password">Senha: </label>
                    </div>
                    <div class="col-auto col-lg-9">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Digite sua senha ...">
                    </div>
                </div>
                <div class="g-recaptcha mb-4 mx-auto" data-sitekey="{{ env('PUBLIC_RECAPTCHA_V2') }}" data-callback="submit"></div>
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                <button type="submit" class="btn btn-primary btn-lg text-light col-8 mx-auto">Logar</button>
            </form>
      </div>
  </article>
@endsection
@section('headers')
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
<?php $robots = 'noindex'; ?>