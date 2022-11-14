@extends('layouts.app')
@section('title', 'Cadastre-se')
@section('content')
    <article class="container">
        <form action="{{ route('dashboard') }}" method="post" novalidate data-action="login" id="login"
              class="form-signin mx-auto d-flex flex-column justify-content-center align-items-center py-5 px-3 needs-validation">
            <img src="{{ url('/img/128.png') }}" alt="Leone Promos">
            <h2 class="fw-normal mb-0">Crie sua conta</h2>
            <span class="small mb-4">Já tem conta? <a href="{{ route('login') }}">Entre</a></span>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-alert type="danger" message="{{ $error }}"></x-alert>
                @endforeach
            @endif
            @csrf
            <div class="form-floating text-start w-100">
                <input type="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) id="email" required
                       name="email" placeholder="Digite seu email ..." value="{{ old('email') }}">
                <label for="email" class="form-label">Email</label>
            </div>
            <div class="form-floating text-start w-100">
                <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) required
                       minlength="8" maxlength="32" id="password" name="password" placeholder="Digite sua senha ...">
                <label for="password" class="form-label">Senha</label>
            </div>
            <div class="d-flex justify-content-between mt-3 w-100">
                <div class="form-check">
                    <input type="checkbox" value=true name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Lembrar-me</label>
                </div>
                <button class="border-0 bg-transparent" id="showPass">
                    <i class="bi bi-eye-fill" id="iconShowPass"></i> <span id="textShowPass">Mostrar</span> senha
                </button>
            </div>
            <button type="submit" class="mt-3 btn btn-primary btn-lg text-light btn-block w-100 mx-auto"
                    id="loginSubmit">
                Cadastrar
            </button>
            <hr class="my-3 col-12">
            <script src="https://accounts.google.com/gsi/client" async defer></script>
            <div id="g_id_onload" data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
                 data-login_uri="{{ route('login.google') }}">
            </div>
            <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                 data-text="continue_with" data-shape="rectangular" data-logo_alignment="left"></div>
        </form>
    </article>
@endsection
@section('headers')
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('VITE_PUBLIC_RECAPTCHA_V3') }}" async></script>
@endsection
