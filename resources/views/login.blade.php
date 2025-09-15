@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <article class="container">
        <h1 class="display-5 mb-4 text-center">Login</h1>
        <div id="login">
            <form action="{{ route('dashboard') }}" method="post"
                  class="col-12 col-md-8 col-lg-6 col-xl-5 mx-auto mt-2 d-flex flex-column border py-5 px-3">
                @csrf
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger w-100 mx-auto" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="form-floating">
                    <input type="text" name="email" id="email" class="form-control"
                           placeholder="Digite seu email ..." required value="{{ old('email') }}">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating my-4">
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Digite sua senha ...">
                    <label for="password">Senha</label>
                </div>
                <div class="g-recaptcha mb-4 mx-auto" data-sitekey="{{ env('PUBLIC_RECAPTCHA_V2') }}"
                     data-callback="submit"></div>
                <button type="submit" class="btn btn-primary btn-lg text-light col-8 mx-auto">Entrar</button>
            </form>
        </div>
    </article>
@endsection
@section('headers')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@php
$robots = 'noindex';
@endphp
