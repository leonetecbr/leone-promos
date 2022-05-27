@extends('layouts.app')
@section('title', 'Rastreio de ecomendas')
@section('content')
  	<article>
    	<h1 class="text-center display-5">Rastreie seu pedido</h1>
    	<p class="text-center my-4">Aproveitou as promções no nosso site para garantir seus produtos ? Nós também te ajudamos na hora de acompanhar a entrega do seu pedido. No momento podemos te ajudar apenas no pedidos que foram enviados pelos Correios, em breve estaremos adicionando suporte a outras transportadoras.</p>
		<div class="col-12 col-lg-8 mx-auto">
			<div id="error-rastreio"></div>
			<form class="needs-validation mt-3" id="rastreio" action="/api/v1/rastreio" novalidate>
				<div class="mb-3">
					<label for="rastreio" class="form-label">Código de rastreamento</label>
					<input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ex: AB000000000BR" minlength="13" maxlength="13" required>
					<div class="invalid-feedback">
						O código de rastreio deve conter 13 caracteres!
					</div>
				</div>
				<div class="text-center small mb-3">Este rastreio é protegido pelo Google reCAPTCHA para garantir que você não é um robô. <a target="_blank" rel="nofollow" href="https://policies.google.com/privacy">Políticas de Privacidade</a> e <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos de Serviço</a> do Google são aplicáveis.</div>
				<div class="mx-auto w-75">
				<button class="btn-block btn btn-primary btn-lg text-light w-100" id="rastreio-submit">Rastrear</button>
				</div>
			</form>
		</div>
    	<div id="rastreamento" class="mt-4">
    	</div>
  	</article>
@endsection