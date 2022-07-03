@extends('layouts.app')
@section('title', $title)
@section('content')
    <article class="container">
        <h1 class="display-5 text-center mb-3">{{ $title }}</h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-center mb-3">{{ $error }}</div>
            @endforeach
        @endif
        <form action="{{ route('promos.save') }}" class="p-3 flex-column" method="post" autocomplete="off">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"/>
            <div class="row mx-auto">
                <div class="col-auto">
                    <label for="name">Título: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="text" value="{{ $promo['name'] ?? old('name') }}" id="name" name="name"
                           class="form-control" required placeholder="Digite o título da promoção ..." maxlength="60"/>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="link">Link: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="text" value="{{ $promo['link'] ?? old('link') }}" id="link" name="link"
                           class="form-control" required placeholder="Digite o link de afiliados da promoção ..."/>
                </div>
            </div>
            <div class="text-end mt-3">
                <input type="checkbox" name="redirect" id="redirect"
                       {{ $promo['redirect'] ?? 'checked' }} class="form-check-input"/> Link de afiliados
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="thumbnail">Imagem: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="text" value="{{ $promo['image'] ?? old('image') }}" id="thumbnail" name="thumbnail"
                           class="form-control" required placeholder="Digite a URL da imagem..."/>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="priceFrom">De: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="number" value="{{ $promo['from'] ?? old('for') }}" id="priceFrom" name="priceFrom"
                           class="form-control" step="0.01" min="0.01" placeholder="Digite o preço anterior ..."/>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="price">Por: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="number" value="{{ $promo['for'] ?? old('for') }}" id="price" name="price"
                           class="form-control" required step="0.01" min="-500" placeholder="Digite o preço atual ..."/>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="installment_quantity">Parcelas: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="number" value="{{ $promo['times'] ?? old('times') }}" id="installment_quantity"
                           name="installment_quantity" class="form-control" min="1" max="48"
                           placeholder="Digite a quantidade máxima de parcelas ..."/>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="installment_value">Valor: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="number" value="{{ $promo['installments'] ?? old('installments') }}"
                           id="installment_value" name="installment_value" class="form-control" step="0.01" min="0"
                           placeholder="Digite o valor de cada parcela ..."/>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="code">Cupom: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="text" value="{{ $promo['code'] ?? old('code') }}" id="code" name="code"
                           class="form-control" placeholder="Digite o cupom ..."/>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="description">Descrição: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <textarea name="description" id="description" class="form-control"
                              placeholder="Digite a descrição da promoção ...">{{ $promo['description'] ?? old('description') }}</textarea>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <div class="col-auto">
                    <label for="store-id">Loja: </label>
                </div>
                <div class="col-12 col-md-10 col-md-11">
                    <input type="number" value="{{ $promo['store_id'] ?? '' }}" id="store-id" name="store_id"
                           placeholder="Digite o id da loja ..."
                           class="form-control @error('store_id') is-invalid @enderror" required/>
                </div>
            </div>
            @if (empty($id))
                <div class="row mx-auto mt-3">
                    <div class="form-check ms-auto col-auto">
                        <input class="form-check-input" type="checkbox" name="notification" id="notificacao" checked>
                        <label class="form-check-label" for="notificacao">Enviar notificação</label>
                    </div>
                    <div class="container flex-row flex-center row-wrap d-md-flex justify-conatent-center flex-wrap mt-3"
                         id="prefers">
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="para" id="all" class="form-check-input" checked>
                            <label for="all" class="form-check-label">Todos</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p1" id="p1" class="form-check-input prefer" checked>
                            <label for="p1" class="form-check-label">Computadores/Notebooks</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p2" id="p2" class="form-check-input prefer" checked>
                            <label for="p2" class="form-check-label">Celulares/Smartphones</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p3" id="p3" class="form-check-input prefer" checked>
                            <label for="p3" class="form-check-label">Itens de Mercado</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p4" id="p4" class="form-check-input prefer" checked>
                            <label for="p4" class="form-check-label">Roupas Masculinas</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p5" id="p5" class="form-check-input prefer" checked>
                            <label for="p5" class="form-check-label">Roupas Femininas</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p6" id="p6" class="form-check-input prefer" checked>
                            <label for="p6" class="form-check-label">Livros</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p7" id="p7" class="form-check-input prefer" checked>
                            <label for="p7" class="form-check-label">Móveis</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p8" id="p8" class="form-check-input prefer" checked>
                            <label for="p8" class="form-check-label">Eletrodomésticos</label>
                        </div>
                        <div class="form-check col-md-6 col-lg-4">
                            <input type="checkbox" name="p9" id="p9" class="form-check-input prefer" checked>
                            <label for="p9" class="form-check-label">Eletroportáteis</label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mt-3">
                <div class="{{ (isset($id))?'col-sm-4':'col-sm-6'; }}">
                    <button type="submit" class="btn btn-primary text-light btn-lg w-100">Salvar</button>
                </div>
                <div class="my-3 my-sm-0 {{ (isset($id))?'col-sm-4':'col-sm-6'; }}">
                    <a href="{{ route('promos.list') }}" class="center">
                        <button type="button" class="btn btn-danger btn-lg w-100">Cancelar</button>
                    </a>
                </div>
                @if (isset($id))
                    <div class="col-sm-4">
                        <input type="hidden" name="id" value="{{ $promo['id'] }}"/>
                        <a href="{{ route('promos.delete', $promo['id']) }}" class="center">
                            <button type="button" class="btn btn-dark btn-lg w-100">Excluir</button>
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </article>
@endsection