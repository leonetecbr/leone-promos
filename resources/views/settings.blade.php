@extends('layouts.app')
@section('title', 'Configurações')
@section('content')
    <div class="container my-3">
        <h2 class="mb-4">Configurações</h2>
        <ul class="nav nav-tabs border-bottom-0" role="tablist" aria-label="Calcular">
            <li class="nav-item" role="presentation">
                <a class="nav-link text-black active" data-bs-toggle="tab" href="#account" role="tab"
                   id="btnAccount" aria-selected="false" aria-controls="account">
                    Conta
                </a>
            </li>
        </ul>
        <div class="tab-content bg-white">
            <div class="tab-pane fade show active p-3" id="account" aria-labelledby="btnAccount" role="tabpanel" aria-selected="true" >
                <h3 class="h5 mb-0">Acesso e segurança</h3>
                <span class="text-muted my-2">Informações do seu acesso ao site.</span>
                <div class="mt-3">
                    <div>
                        <button class="bg-transparent border-0 px-0" type="button">
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
                    <button class="bg-transparent border-0 px-0" type="button">
                        Alterar senha
                    </button>
                </div>
                <h3 class="h5 mb-0 mt-4">Excluir conta</h3>
                <span class="text-muted my-2">Apague definitivamente seus dados e conta.</span>
                <div class="mt-3">
                    <button class="bg-transparent border-0 px-0" type="button">
                        Excluir minha conta
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
