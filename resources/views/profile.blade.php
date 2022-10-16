@extends('layouts.app')
@if($myProfile)
    @section('title', 'Meu perfil')
@else
    @section('title', 'Perfil: ' . $user->name)
@endif
@section('content')
    <div class="container text-center">
        <div id="profilePicture">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-alert type="danger" message="{{ $error }}"></x-alert>
                @endforeach
            @endif
            @if (session()->has('success'))
                <x-alert type="success" message="{{ session('success') }}"></x-alert>
            @endif
            <img src="{{ $user->getAvatar() }}" alt="Foto de {{ '@' . $user->username }}"
             class="rounded-circle" width="96" height="96">
            <button class="bg-white border-0 rounded-circle position-relative" id="updateProfilePicture"
                    aria-label="Mudar foto do perfil">
                <i class="bi bi-camera-fill"></i>
            </button>
            <form action="{{ route('profile.newPicture') }}" method="post" id="newPictureForm" enctype="multipart/form-data">
                @csrf
                <input type="file" name="profile_picture" id="newProfilePicture" accept="image/png, image/jpeg"
                   class="d-none" required>
            </form>
        </div>
        <h2 class="my-1">
            {{ '@' . $user->username }}
            @if($myProfile)
                <sup>
                    <button class="border-0 bg-transparent rounded-circle fs-6 p-0" aria-label="Editar nome"
                            id="btn-edit-name" data-bs-target="#edit-name" data-bs-toggle="modal">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </sup>
            @endif
        </h2>
        <span class="text-muted">Entrou em {{ $user->getCreateDate() }}</span>
        <hr>
    </div>
    @if($myProfile)
        <div class="modal fade" id="edit-name" tabindex="-1" aria-labelledby="btn-edit-name" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Novo nome de usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit-name-form" method="post" action="{{ route('profile.editUsername') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="username-edit" class="col-form-label">Nome de usuário:</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" value="{{ $user->username }}" required
                                           id="username-edit" minlength="3" maxlength="32" name="username">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="edit-name-submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
