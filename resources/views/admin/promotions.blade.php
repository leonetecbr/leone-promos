@extends('layouts.app')
@php
if (isset($promotion)) {
    $action = route('promotions.update', $promotion->id);
    $redirect = str_starts_with($promotion->link, '/redirect?url=');
} else {
    $action = route('promotions.store');
    $redirect = true;
}
@endphp
@section('title', $title)
@section('content')
    <article class="container">
        <h1 class="display-5 text-center mb-3">{{ $title }}</h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <form action="{{ $action }}" class="p-3 needs-validation" method="post" autocomplete="off" novalidate>
            @if (isset($promotion))
                @method('PUT')
            @endif
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"/>
            <div class="form-floating">
                <input type="text" value="{{ old('title', $promotion->title ?? '') }}" id="title" name="title"
                       class="form-control" required placeholder="Digite o título da promoção ..." maxlength="60"/>
                <label for="title">Título</label>
            </div>
            <div class="form-floating my-3">
                <input type="text" value="{{ old('link', $promotion->link ?? '') }}" id="link" name="link"
                       class="form-control" required placeholder="Digite o link de afiliados da promoção ..."/>
                <label for="link">Link</label>
            </div>
            <div class="form-check form-switch d-flex justify-content-end gap-2">
                <input class="form-check-input" type="checkbox" role="switch" id="redirect" name="redirect"
                       @checked(old('redirect', $redirect)) value="1">
                <label class="form-check-label" for="redirect">Gerar link de afiliados</label>
            </div>
            <div class="form-floating my-3">
                <input type="text" value="{{ old('image', $promotion->image ?? '') }}" id="image" name="image"
                       class="form-control" required placeholder="Digite a URL da imagem..."/>
                <label for="image">Imagem</label>
            </div>
            <div class="form-floating">
                <input type="number" value="{{ old('was', $promotion->was ?? '') }}" id="was" name="was"
                       class="form-control" step="0.01" min="0.01" placeholder="Digite o preço anterior ..."/>
                <label for="was">De</label>
            </div>
            <div class="form-floating my-3">
                <input type="number" value="{{ old('for', $promotion ?? '') }}" id="for" name="for"
                       class="form-control" required step="0.01" min="-500" placeholder="Digite o preço atual ..."/>
                <label for="for">Por</label>
            </div>
            <div class="form-floating">
                <input type="number" value="{{ old('times', $promotion->times ?? '') }}" id="times" name="times"
                       class="form-control" min="1" max="48"
                       placeholder="Digite a quantidade máxima de parcelas ..."/>
                <label for="times">Parcelas</label>
            </div>
            <div class="form-floating my-3">
                <input type="number" value="{{ old('installments', $promotion->installments ?? '') }}"
                       id="installments" name="installments" class="form-control" step="0.01" min="0"
                       placeholder="Digite o valor de cada parcela ..."/>
                <label for="installments">Valor</label>
            </div>
            <div class="form-floating">
                <input type="text" value="{{ old('code', $promotion->code ?? '') }}" id="code" name="code"
                       class="form-control" placeholder="Digite o cupom ..."/>
                <label for="code">Cupom</label>
            </div>
            <div class="form-floating my-3">
                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    placeholder="Digite a descrição da promoção ..."
                    style="height: 100px"
                >{{ old('description', $promotion->description ?? '') }}</textarea>
                <label for="description">Descrição</label>
            </div>
            <div class="form-floating">
                <select class="form-select @error('store_id') is-invalid @enderror" id="store-id" name="store_id"
                        required aria-label="Selecione a loja">
                    <option selected hidden disabled>Selecione a loja</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}"
                            @selected(old('store_id', $promotion->store_id ?? '') == $store->id)>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
                <label for="store-id">Loja</label>
            </div>
            <div class="form-check form-switch mt-3 d-flex justify-content-end gap-2">
                <input class="form-check-input" type="checkbox" role="switch" id="top-promotions" name="is_top"
                    @checked(old('is_top', $promotion->is_top ?? true)) value="1">
                <label class="form-check-label" for="top-promotions">Exibir nas melhores promoções</label>
            </div>
            @if (!isset($promotion))
                <div class="row mx-auto mt-3">
                    <div class="form-check ms-auto col-auto">
                        <input class="form-check-input" type="checkbox" name="notification" id="notification"
                               @checked(old('checked', true)) value="1">
                        <label class="form-check-label" for="notification">Enviar notificação</label>
                    </div>
                    <div
                        class="container flex-row flex-center row-wrap d-md-flex justify-content-center flex-wrap mt-3"
                        id="prefers">
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="para" id="all" class="form-check-input" checked>
                            <label for="all" class="form-check-label">Todos</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p1" id="p1" class="form-check-input prefer" checked value="1">
                            <label for="p1" class="form-check-label">Computadores/Notebooks</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p2" id="p2" class="form-check-input prefer" checked value="1">
                            <label for="p2" class="form-check-label">Celulares/Smartphones</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p3" id="p3" class="form-check-input prefer" checked value="1">
                            <label for="p3" class="form-check-label">Itens de Mercado</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p4" id="p4" class="form-check-input prefer" checked value="1">
                            <label for="p4" class="form-check-label">Roupas Masculinas</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p5" id="p5" class="form-check-input prefer" checked value="1">
                            <label for="p5" class="form-check-label">Roupas Femininas</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p6" id="p6" class="form-check-input prefer" checked value="1">
                            <label for="p6" class="form-check-label">Livros</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p7" id="p7" class="form-check-input prefer" checked value="1">
                            <label for="p7" class="form-check-label">Móveis</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p8" id="p8" class="form-check-input prefer" checked value="1">
                            <label for="p8" class="form-check-label">Eletrodomésticos</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p9" id="p9" class="form-check-input prefer" checked value="1">
                            <label for="p9" class="form-check-label">Eletroportáteis</label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mt-3">
                @if (isset($promotion))
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-dark btn-lg w-100" id="delete-promotion"
                                data-bs-toggle="modal" data-bs-target="#confirmDeletePromotion">
                            Excluir
                        </button>
                    </div>
                @endif
                <div class="my-3 my-sm-0 {{ isset($promotion) ? 'col-sm-4' : 'col-sm-6' }}">
                    <a href="{{ route('promotions.index') }}" class="center">
                        <button type="button" class="btn btn-danger btn-lg w-100">
                            Cancelar
                        </button>
                    </a>
                </div>
                <div class="{{ isset($promotion) ? 'col-sm-4' : 'col-sm-6' }}">
                    <button type="submit" class="btn btn-primary text-light btn-lg w-100">
                        Salvar
                    </button>
                </div>
            </div>
        </form>
    </article>
    @if (isset($promotion))
        @include('admin.modals.confirm-delete-promotion')
    @endif
@endsection
