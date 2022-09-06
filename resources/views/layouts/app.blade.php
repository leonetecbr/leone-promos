<!DOCTYPE html>
<html lang="pt-br">
<?php
if (Request::filled('tag') && Request::input('utm_source') == 'push_notification') {
    require_once(__DIR__ . '/../../../app/Includes/clickNotification.php');
}
?>
<head>
    <meta charset="UTF-8"/>
    @if (!env('APP_DEBUG'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-VHZEX7GYK2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', 'G-VHZEX7GYK2');
        </script>
    @endif
    <link rel="stylesheet" type="text/css" href="{{ mix('css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.min.css') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    @hasSection('description')
        <meta name="description" content="@yield('description')">
        <meta name="og:description" content="@yield('description')">
    @else
        <meta name="description"
              content="Aproveite as melhores promoções e os melhores cupons das melhores lojas da internet com total segurança!">
        <meta name="og:description"
              content="Aproveite as melhores promoções e os melhores cupons das melhores lojas da internet com total segurança!">
    @endif
    @hasSection('keywords')
        <meta name="keywords" content="@yield('keywords')">
    @endif
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
    <meta name="author" content="Leone Oliveira">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://kit.fontawesome.com/6719bc67c5.js" crossorigin="anonymous" async></script>
    <link rel="icon" href="{{ url('/img/icon.png') }}">
    <meta property="og:locale" content="pt_BR"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
    <meta property="og:url" content="{{ Request::url() }}"/>
    <meta property="og:title" content="@yield('title') | {{ env('APP_NAME') }}"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Ofertas"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-TileColor" content="#da6709"/>
    <meta name="msapplication-TileImage" content="{{ url('/img/icon.png') }}"/>
    <link rel="apple-touch-icon" href="{{ url('/img/icon.png') }}"/>
    <link rel="manifest" href="{{ url('/json/manifest.json') }}">
    <meta name="application-name" content="Ofertas">
    <link rel="icon" sizes="152x152" href="{{ url('/img/152.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/img/152.png') }}"/>
    <link rel="icon" sizes="144x144" href="{{ url('/img/144.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('/img/144.png') }}"/>
    <link rel="icon" sizes="128x128" href="{{ url('/img/128.png') }}">
    <link rel="icon" sizes="96x96" href="{{ url('/img/96.png') }}">
    <link rel="icon" sizes="90x90" href="{{ url('/img/90.png') }}">
    <link rel="icon" sizes="72x72" href="{{ url('/img/72.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('/img/72.png') }}"/>
    <link rel="icon" sizes="64x64" href="{{ url('/img/64.png') }}">
    <link rel="icon" sizes="60x60" href="{{ url('/img/60.png') }}">
    <link rel="icon" sizes="32x32" href="{{ url('/img/32.png') }}">
    <link rel="icon" sizes="16x16" href="{{ url('/img/16.png') }}">
    <meta name="theme-color" content="#da6709">
    <link rel="canonical" href="{{ Request::url() }}"/>
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('PUBLIC_RECAPTCHA_V3') }}"
            async></script>@yield('headers')
</head>
<body class="d-flex flex-column min-vh-100">
@if (empty($_COOKIE['accept']))
    <section class="fixed-bottom bg-primary col-12 col-md-9 col-lg-8 mx-auto mb-md-3 text-light p-3" id="aviso-cookie">
        <div class="mb-2">Esse site utiliza cookies para te dá uma melhor experiência de navegação. <a
                href="{{ route('cookies') }}" target="_blank" class="text-light">Saiba mais &raquo;</a></div>
        <div class="text-end">
            <button class="btn btn-outline-light" id="accept">Fechar e aceitar</button>
        </div>
    </section>
@endif
<header id="cabecalho" class="border border-bottom container-fluid bg-light">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a href="{{ route('home') }}" class="navbar-brand" id="logo">
            <{{ (Route::currentRouteName()=='home')?'h1':'span'; }} class
            ="d-none">{{ env('APP_NAME') }}</{{ (Route::currentRouteName()=='home')?'h1':'span'; }}>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ (Route::currentRouteName()=='home')?'#':route('home') }}"
                       class="nav-link{{ (Route::currentRouteName()=='home')?' active':''; }}">Início</a>
                </li>
                <li class="nav-item">
                    <a href="{{ (Route::currentRouteName()=='cupons')?'#':route('cupons') }}"
                       class="nav-link{{ (Route::currentRouteName()=='cupons')?' active':''; }}">Cupons</a>
                </li>
                <li class="nav-item">
                    <a href="{{ (Route::currentRouteName()=='lojas')?'#':route('lojas') }}"
                       class="nav-link{{ (Route::currentRouteName()=='lojas')?' active':''; }}">Lojas</a>
                </li>
                <li class="nav-item">
                    <a href="{{ (Route::currentRouteName()=='categorias')?'#':route('categorias') }}"
                       class="nav-link{{ (Route::currentRouteName()=='categorias')?' active':''; }}">Categorias</a>
                </li>
                <li class="nav-item">
                    <a href="{{ (Route::currentRouteName()=='notificacoes')?'#':route('notificacoes') }}"
                       class="nav-link{{ (Route::currentRouteName()=='notificacoes')?' active':''; }}">Notificações</a>
                </li>
                <li class="nav-item">
                    <a href="{{ (Route::currentRouteName()=='rastreio')?'#':route('rastreio') }}"
                       class="nav-link{{ (Route::currentRouteName()=='rastreio')?' active':''; }}">Rastreio</a>
                </li>
            </ul>
            <form id="search" class="d-flex justify-content-center ajax-form col-lg-3 col-xl-4 ms-3"
                  data-action="search" action="/search/" novalidate>
                <div class="me-2">
                    <input class="form-control" type="search" placeholder="Pesquisar" minlength="3" maxlength="20"
                           required aria-label="Pesquisar" value="{{ $query ?? '' }}" name="q" id="q">
                </div>
                <div>
                    <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="text-center small py-3 d-lg-none w-75 mx-auto">Esta pesquisa é protegida pelo Google reCAPTCHA
                para garantir que você não é um robô. <a target="_blank" rel="nofollow"
                                                         href="https://policies.google.com/privacy">Políticas de
                    Privacidade</a> e <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos
                    de Serviço</a> do Google são aplicáveis.
            </div>
            @if (Auth::check())
                <a href="{{ route('dashboard') }}" class="ms-3">
                    <button id="btn-admin" class="btn btn-outline-info mt-3 mt-md-0 float-start"><i
                            class="fa-solid fa-lock"></i></button>
                </a>
                <a href="{{ route('logout') }}" class="ms-3">
                    <button id="btn-logout" class="btn btn-outline-danger mt-3 mt-md-0 float-end"><i
                            class="fas fa-sign-out-alt"></i></button>
                </a>
            @endif
        </div>
    </nav>
    <div class="text-end small pb-3 d-none d-lg-block">Esta pesquisa é protegida pelo Google reCAPTCHA para garantir que
        você não é um robô. <a target="_blank" rel="nofollow" href="https://policies.google.com/privacy">Políticas de
            Privacidade</a> e <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos de
            Serviço</a> do Google são aplicáveis.
    </div>
</header>
@if (empty($_COOKIE['no_notification']) && (Route::currentRouteName()!='notificacoes'))
    <div id="notification" class="container d-none border-bottom p-3">
        <p>Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador!</p><br/>
        <div class="float-end me-2" id="i-notification"><i class="fw-bolder far fa-eye-slash pointer"></i></div>
        <div class="text-center">
            <button id="btn-notification" class="btn btn-primary text-light" disabled>Ativar notificações</button>
        </div>
    </div>
@endif
<form action="/search/" id="search-desktop" data-action="search" class="d-none d-lg-none needs-validation p-3"
      method="post" novalidate>
    <div class="row mb-3">
        <div class="col-10 col-sm-11">
            <input type="search" name="q" id="qs" placeholder="Digite sua pesquisa ..." class="form-control" required
                   autocomplete="off" value="{{ $query ?? '' }}"/>
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-outline-success"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <div class="invalid-feedback">Pesquisa inválida (Mínimo de 3 caracteres e máximo 20)</div>
    <p class="small">Esta pesquisa é protegida pelo Google reCAPTCHA para garantir que você não é um robô. <a
            target="_blank" rel="nofollow" href="https://policies.google.com/privacy">Políticas de Privacidade</a> e
        <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos de Serviço</a> do Google são
        aplicáveis.</p>
</form>
<div class="d-flex justify-content-center">
    <div class="toast align-items-center text-white bg-success border-0 position-fixed fs-5 z-index-fixed"
         id="copy-success" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body mx-auto">
                <i class="fa fa-check"></i> Texto copiado com sucesso!
            </div>
        </div>
    </div>
    <div class="col-8 col-lg-6 toast align-items-center text-white bg-danger border-0 position-fixed fs-5 z-index-fixed"
         id="error-alert" data-bs-delay="5000">
        <div class="d-flex">
            <div class="toast-body mx-auto">
                <i class="fa-solid fa-xmark"></i> <span id="error-message"></span>
            </div>
        </div>
    </div>
</div>
<main class="p-3 px-md-5 my-auto">
    @yield('content')
</main>
<div class="wp-button rounded-circle text-light float-end text-center">
    <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}" target="_blank" rel="nofollow" id="btn-whatsapp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>
<script>
    const CSRF = '{{ csrf_token() }}';
    const KEY_V3_RECAPTCHA = '{{ env("PUBLIC_RECAPTCHA_V3") }}';
    const KEY_VAPID_PUBLIC = '{{ env("VAPID_PUBLIC_KEY") }}';
</script>
<script src="{{ mix('js/jquery.min.js') }}"></script>
@yield('scripts')
<script src="{{ mix('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ mix('js/functions.js') }}" async defer></script>
<script src="{{ mix('js/app.min.js') }}" async defer></script>
<footer id="rodape" class="text-center border-top p-3 bg-light mt-auto">
    <div id="social" class="mx-auto fs-2 mb-3">
        <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}"><i class="fab fa-whatsapp-square"></i></a>
        <a href="https://instagram.com/ofertas.leone"><i class="fab fa-instagram-square"></i></a>
        <a href="https://facebook.com/ofertas.leone"><i class="fab fa-facebook-square"></i></a>
        <a href="https://github.com/leonetecbr/leone-promos/"><i class="fab fa-github-square"></i></a>
    </div>
    <div id="copyright" class="fs-6 fw-light">
        <p>Ao abrir ou comprar um produto mostrado aqui no site, algumas lojas poderão nos pagar uma comissão, mas isso
            não influencia em quais promoções são postadas por aqui. Em caso de divergência no preço, o preço válido é o
            da loja. O preço informado não inclui frete e outras taxas. Consulte termos e condições das ofertas e
            cupons.</p>
        <p><span class="fw-bolder">&copy; {{ date('Y') }} - {{ env('APP_NAME') }}</span> - Todos os direitos reservados.
        </p>
    </div>
    <p class="fs-6">
        <span class="bolder">Políticas: </span> <a href="`{{ route('privacidade') }}" target="_blank"
                                                   class="text-decoration-none">de Privacidade</a> | <a
            href="{{ route('cookies') }}" target="_blank"
            class="text-decoration-none">de Cookies</a>
    </p>
</footer>
</body>
</html>
