@extends('layouts.app')
@section('title', 'Configurações')
@section('content')
    <div class="container my-3">
        <h2 class="mb-4">Configurações</h2>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <x-alert type="danger" message="{{ $error }}"></x-alert>
            @endforeach
        @endif
        @if (session()->has('success'))
            <x-alert type="success" message="{{ session('success') }}"></x-alert>
        @endif
        <ul class="nav nav-tabs border-bottom-0" role="tablist" aria-label="Calcular">
            <li class="nav-item" role="presentation">
                <a class="nav-link text-black active" data-bs-toggle="tab" href="#account" role="tab"
                   id="btnAccount" aria-selected="false" aria-controls="account">
                    Conta
                </a>
            </li>
        </ul>
        <div class="tab-content bg-white">
            <div class="tab-pane fade show active p-3" id="account" aria-labelledby="btnAccount" role="tabpanel"
                 aria-selected="true">
                <h3 class="h5 mb-0">Acesso e segurança</h3>
                <span class="text-muted my-2">Informações do seu acesso ao site.</span>
                <div class="mt-3">
                    <div>
                        <button class="bg-transparent border-0 px-0" type="button" data-bs-target="#changeMail"
                                data-bs-toggle="modal" id="changeMailLabel">
                            Alterar email
                        </button>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">{{ request()->user()->email }}</span>
                            @if (is_null(request()->user()->email_verified_at))
                                <div class="text-danger d-flex">
                                    <i class="bi bi-check-circle-fill"></i>&nbsp;
                                    <span class="d-none d-sm-block">Não verificado</span>
                                </div>
                            @else
                                <div class="text-success d-flex">
                                    <i class="bi bi-check-circle-fill"></i>&nbsp;
                                    <span class="d-none d-sm-block">Verificado</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr class="my-2 mx-1">
                    <button class="bg-transparent border-0 px-0" type="button" data-bs-target="#changePass"
                            data-bs-toggle="modal" id="changePassLabel">
                        {{ (is_null($user->password)) ? 'Definir senha' : 'Alterar senha' }}
                    </button>
                </div>
                <h3 class="h5 mb-0 mt-4">Excluir conta</h3>
                <span class="text-muted my-2">Apague definitivamente seus dados e conta.</span>
                <div class="mt-3">
                    <button class="bg-transparent border-0 px-0" type="button" data-bs-target="#deleteAccount"
                            data-bs-toggle="modal" id="deleteAccountLabel">
                        Excluir minha conta
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changeMail" tabindex="-1" aria-labelledby="changeMailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alterar email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changeMailForm" method="post" action="{{ route('settings.changeMail') }}"
                      class="simple-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="changeMailInput" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" required name="email"
                                   id="changeMailInput">
                            <div class="invalid-feedback text-center">
                                Insira um email válido.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="changeMailSubmit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changePass" tabindex="-1" aria-labelledby="changePassLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ (is_null($user->password)) ? 'Definir senha' : 'Alterar senha' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePassForm" method="post" action="{{ route('settings.changePass') }}"
                      class="simple-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        @if (!is_null($user->password))
                            <div class="mb-3">
                                <label for="currentPassInput" class="col-form-label">Senha atual:</label>
                                <input type="password" class="form-control" required name="current_password"
                                       id="currentPassInput" placeholder="Digite sua senha atual ..."
                                       minlength="8" maxlength="32">
                                <a class="small float-end" href="">
                                    Esqueceu sua senha?
                                </a>
                                <div class="invalid-feedback text-center">
                                    A senha deve ter de 8 a 32 caracteres.
                                </div>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="newPassInput" class="col-form-label">Nova senha:</label>
                            <input type="password" class="form-control" required name="password" id="newPassInput"
                                   placeholder="Digite a nova senha ..."
                                   minlength="8" maxlength="32">
                            <div class="invalid-feedback text-center">
                                A senha deve ter de 8 a 32 caracteres.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="changePassSubmit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAccount" tabindex="-1" aria-labelledby="deleteAccountLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Excluir conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteAccountForm" method="post" action="{{ route('settings.deleteAccount') }}">
                    @csrf
                    <div class="modal-body text-center">
                        <h4>Leia com atenção!</h4>
                        <p>
                            Você tem certeza que deseja excluir sua conta?
                            Esta ação não pode ser desfeita, todos os seus dados serão apagados permanentemente.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger" id="deleteAccountSubmit">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
