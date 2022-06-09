@extends('layouts.app')
@section('title', 'Notificações')
@section('keywords', ', promoção, menor preço, ofertas, promoções, oferta, notificações, aviso, alerta')
@section('description', 'Ative nossas notificações, edite suas preferências e não perca nenhuma promoção imperdível.')
@section('content')
    <article class="container">
        <h1 class="display-5">Gerenciar notificações</h1>
        <div id="notifications">
            <p class="my-3">Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador! Aqui você pode ativar, desativar e gerenciar suas preferências de notificação.</p>
            <div class="text-center mb-3">
                <button id="btn-notification" class="btn btn-primary text-light" disabled>Ativar notificações</button>
            </div>
            <div class="text-center small">O sistema de notificações é protegido pelo Google reCAPTCHA para garantir que você não é um robô. <a target="_blank" rel="nofollow" href="https://policies.google.com/privacy">Políticas de Privacidade</a> e <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos de Serviço</a> do Google são aplicáveis.</div>
        </div>

        <div id="notification-blocked" class="d-none">
            <div class="display-6 my-3">Veja como resolver</div>
            <p>Você bloqueou as nossas notificações, mas calma você pode desbloquear facilmente, basta seguir os passos informados abaixo.</p>
            <div class="text-center">
                <img src="{{ url('/img/ajuda/desbloquear-notificacoes-browser.png') }}" alt="Menu de configurações de sites no Google Chrome"/>
                <p class="my-3 text-muted">Clique no cadeado e procure por "Notificações" se estiverem bloqueadas ou desativadas como na imagem, ative ou escolha "Sempre permitir", recarregue a página e tente ativar novamente.</p>
            </div>
        </div>

        <div id="notification-unsupported" class="d-none">
            <div class="display-6 my-3">Veja como resolver</div>
            <div class="accordion mw-700 mx-auto fs-5 text-center">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingIg">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIg" aria-expanded="false" aria-controls="collapseIg">Está no Instagram ou outra rede social ?</button>
                    </h2>
                    <div id="collapseIg" class="accordion-collapse collapse" aria-labelledby="headingIg" data-bs-parent="#notification-unsupported">
                        <div class="accordion-body">
                            <h3 class="fw-light mb-3">Siga esses passo para conseguir ativar!</h3>
                            <img src="{{ url('/img/ajuda/barra-navegador-instagram.jpg')) }}" alt="Barra do navegador integrado do Instagram">
                            <p class="my-3 text-muted">Clique nos "3 pontinhos" para acessar mais opções do navegador do Instagram.</p>
                            <img src="{{ url('/img/ajuda/abrir-no-navegador-instagram.jpg') }}" alt="Menu da barra do navegador integrado do Instagram">
                            <p class="my-3 text-muted">Agora clique em "Abrir no Chrome" ou no navegador de sua preferência.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingIg">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrowser" aria-expanded="false" aria-controls="collapseBrowser">Está num navegador comum ?</button>
                    </h2>
                    <div id="collapseBrowser" class="accordion-collapse collapse" aria-labelledby="headingBrowser" data-bs-parent="#notification-unsupported">
                        <div class="accordion-body">
                            <p>Nós recomendamos o uso de um dos seguintes navegadores:</p>
                            <ul class="mx-auto mw-300">
                                <li class="text-start">Chrome</li>
                                <li class="text-start">Firefox</li>
                                <li class="text-start">Edge</li>
                            </ul>
                            <p>Se você já está usando um desses navegadores, verifique se há atualizações disponíveis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="preferencias" class="d-none mt-3">
            <h2 class="display-6">Preferências</h2>
            <p>Você deseja ser notificado sempre que houver promoção de: </p>
            <div class="text-center mb-3 d-none" id="error-pref-form"></div>
            <form action="{{ route('prefer.set') }}" method="post" class="ajax-form container" id="pref-form" data-action="update_prefer">
                <div class="container flex-row flex-center row-wrap d-md-flex justify-content-center flex-wrap" id="prefers">
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p0" id="all" class="form-check-input">
                        <label for="all" class="form-check-label" >Tudo</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p1" id="p1" class="form-check-input prefer">
                        <label class="form-check-label" for="p1">Computadores/Notebooks</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p2" id="p2" class="form-check-input prefer">
                        <label for="p2" class="form-check-label" >Celulares/Smartphones</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p3" id="p3" class="form-check-input prefer">
                        <label for="p3" class="form-check-label" >Itens de Mercado</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p4" id="p4" class="form-check-input prefer">
                        <label for="p4" class="form-check-label" >Roupas Masculinas</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p5" id="p5" class="form-check-input prefer">
                        <label for="p5" class="form-check-label" >Roupas Femininas</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p6" id="p6" class="form-check-input prefer">
                        <label for="p6" class="form-check-label" >Livros</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p7" id="p7" class="form-check-input prefer">
                        <label for="p7" class="form-check-label" >Móveis</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p8" id="p8" class="form-check-input prefer">
                        <label for="p8" class="form-check-label" >Eletrodomésticos</label>
                    </div>
                    <div class="form-check col-md-6 col-lg-4">
                        <input type="checkbox" name="p9" id="p9" class="form-check-input prefer">
                        <label for="p9" class="form-check-label" >Eletroportáteis</label>
                    </div>
                </div>
                <input type="hidden" name="endpoint" id="endpoint">
                <div class="text-center">
                    <button class="btn btn-primary text-light mt-3" type="submit" id="pref-form-submit">Salvar</button>
                </div>
            </form>
        </div>
    </article>
@endsection