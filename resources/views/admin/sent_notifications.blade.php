@extends('layouts.app')
@section('title', 'Histórico de notificações')
@section('content')
    <article class="container">
        <h1 class="display-5 text-center mb-3">Histórico de notificações</h1>
        @if (empty($notifications))
            <div class="alert alert-warning w-75 mx-auto mt-4" role="alert">
                Nenhuma notificação encontrada!
            </div>
        @else
            <div class="notifications d-lg-flex justify-content-around flex-wrap">
                @foreach($notifications as $notification)
                    <div class="notification col-lg-5 border border-1 d-flex flex-column mt-4">
                        <div class="toast-header">
                            <div class="me-auto fw-bolder">{{ $notification->title }}</div>
                            <div class="small">{{ $notification->sent_at }}</div>
                        </div>
                        <div class="toast-body my-auto">
                            <div class="text-center mb-2">
                                <img src="{{ $notification->image ?? '/img/sem-imagem.jpeg' }}" class="h-200"/>
                            </div>
                            {{ $notification->content}}
                        </div>
                        <div class="toast-footer border border-bottom d-flex justify-content-between p-2 flex-wrap">
                            <div class="col-4">
                                Para: {{ $notification->to}} usuário(s)
                            </div>
                            <div class="col-4 text-center">
                                Cliques: {{ $notification->clicks}}
                            </div>
                            <div class="col-4 text-end">
                                <a href="{{ $notification->link}}">Link</a>
                            </div>
                            <div class="col-12 mt-3 text-center text-muted">
                                Enviado por: {{ $notification->by}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $notifications->onEachSide(0)->links() }}
            <div class="container text-center flex-column fs-12 bolder top" id="btn-topo">
                <button class="rounded bg-primary px-3 py-2 border-0">
                    <i class="fas fa-angle-double-up text-white"></i>
                </button>
                <p class="fs-5 my-2 fw-light">Topo</p>
            </div>
        @endif
        <div class="text-center mt-3">
            <a href="{{ route('dashboard') }}" class="col-5">
                <button type="button" class="btn btn-primary text-white w-75 btn-lg">Voltar</button>
            </a>
        </div>
    </article>
@endsection
