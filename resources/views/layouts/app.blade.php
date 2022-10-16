<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    @if (!env('APP_DEBUG') && env('GA_TRACKING_ID'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA_TRACKING_ID') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{ env('GA_TRACKING_ID') }}');
        </script>
    @endif
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/bootstrap.scss') }}">
    <link rel="stylesheet" href="{{ Vite::asset('node_modules/bootstrap-icons/font/bootstrap-icons.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <meta name="keywords" content="{{ env('APP_NAME') }}, @yield('keywords')">
    @else
        <meta name="keywords"
              content="{{ env('APP_NAME') }}, promoção, menor preço, ofertas, promoções, oferta, cupom, cupons">
    @endif
    @if (request()->routeIs('search'))
        <meta name="robots" content="noindex">
    @else
        <meta name="robots" content="index, follow">
    @endif
    <meta name="author" content="Leone Oliveira">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('title') | {{ env('APP_NAME') }}">
    <link rel="manifest" href="{{ url('/manifest.json') }}">
    <meta name="application-title" content="Ofertas">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Ofertas">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ url('/img/icon.png') }}">
    <meta name="msapplication-TileColor" content="#da6709">
    <meta name="msapplication-TileImage" content="{{ url('/img/icon.png') }}">
    <link rel="icon" href="{{ url('/img/icon.png') }}">
    <meta name="theme-color" content="#da6709">
    <link rel="canonical" href="{{ request()->url() }}">
    @yield('headers')
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
@if (empty($_COOKIE['accept']))
    <section class="fixed-bottom bg-primary col-12 col-md-9 col-lg-8 mx-auto mb-md-3 text-light p-3" id="alertCookie" role="alert">
        <div class="mb-2">Esse site utiliza cookies para te dá uma melhor experiência de navegação. <a
                href="{{ route('cookies') }}" target="_blank" class="text-light">Saiba mais &raquo;</a></div>
        <div class="text-end">
            <button type="button" class="btn btn-outline-light" id="accept">
                Fechar e aceitar
            </button>
        </div>
    </section>
@endif
<header id="cabecalho" class="border border-bottom bg-light sticky-top shadow-sm">
    <nav class="navbar navbar-expand-md navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-primary fw-bolder fs-4"
               href="{{ request()->routeIs('home') ? '#' : env('APP_URL') }}">
                <img src="{{ url('/img/icon.png') }}" alt="{{ env('APP_NAME') }}" width="45">
                {{ env('APP_NAME') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <x-nav-item route="home" title="Início"></x-nav-item>
                    <x-nav-item route="coupons" title="Cupons"></x-nav-item>
                    <x-nav-item route="stores" title="Lojas"></x-nav-item>
                    <x-nav-item route="categories" title="Categorias"></x-nav-item>
                    <x-nav-item route="notifications" title="Notificações"></x-nav-item>
                    <x-nav-item route="tracking" title="Rastreio"></x-nav-item>
                </ul>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary text-white mt-3 ms-3 mt-md-0 float-start"
                       aria-label="Cadastre-se">
                        <i class="bi bi-person-plus-fill"></i>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary mt-3 ms-3 mt-md-0 float-end"
                       aria-label="Entre">
                        <i class="bi bi-person-check-fill"></i>
                    </a>
                @else
                    <div class="dropstart ms-3">
                        <button class="border-0 bg-transparent dropdown-toggle" id="dropdownUser" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Menu de usuário</span>
                            <img src="{{ request()->user()->getAvatar() }}" alt="{{ request()->user()->username }}" width="24" height="24" class="rounded-circle">
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownUser">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">Perfil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings') }}">Configurações</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</header>
@if (empty($_COOKIE['no_notification']) && !request()->routeIs('notifications'))
    <div id="notification" class="container d-none border-bottom p-3">
        <p>Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador!</p><br>
        <div class="float-end me-2" id="i-notification"><i class="fw-bolder far fa-eye-slash pointer"></i></div>
        <div class="text-center">
            <button id="btn-notification" class="btn btn-primary text-light" disabled type="button">
                Ativar notificações
            </button>
        </div>
    </div>
@endif
<div class="d-flex justify-content-center">
    <div class="toast text-white bg-success position-fixed fs-5 z-index-fixed" id="copySuccess"
         data-bs-delay="3000" role="alert" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body mx-auto">
                <i class="fa fa-check"></i> Texto copiado com sucesso!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Fechar">
            </button>
        </div>
    </div>
    <div class="toast col-10 text-white bg-danger position-fixed fs-5 z-index-fixed" id="errorToast"
         data-bs-delay="3000" role="alert" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <span id="errorMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Fechar">
            </button>
        </div>
    </div>
</div>
<main class="px-3 my-auto">
    @if(request()->routeIs('home'))
        <h1 class="visually-hidden">{{ env('APP_NAME') }}</h1>
    @endif
    @yield('content')
</main>
@vite('resources/js/app.js')
@yield('scripts')
<footer class="text-center border-top p-3 bg-white mt-auto">
    <div id="social" class="mx-auto fs-2 mb-3">
        <a href="https://github.com/leonetecbr/leone-promos/" aria-label="GitHub"><i class="bi bi-github"></i></a>
        <a href="https://facebook.com/ofertas.leone" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
        <a href="https://instagram.com/ofertas.leone" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="https://www.linkedin.com/in/leonetecbr/" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
    </div>
    <div id="copyright" class="small">
        <p>Ao abrir ou comprar um produto mostrado aqui no site, algumas lojas poderão nos pagar uma comissão, mas isso
            não influencia em quais promoções são postadas por aqui. Em caso de divergência no preço, o preço válido é o
            da loja. O preço informado não inclui frete e outras taxas. Consulte termos e condições das ofertas e
            cupons.</p>
        <p>
            <span class="fw-bolder">&copy; {{ date('Y') }} - {{ env('APP_NAME') }}</span> - Todos os direitos
            reservados.
        </p>
    </div>
    <p class="fs-6">
        <span class="bolder">Políticas: </span>
        <a href="{{ route('privacidade') }}" target="_blank">
            de Privacidade
        </a> | <a href="{{ route('cookies') }}" target="_blank">
            de Cookies
        </a>
    </p>
</footer>
</body>
</html>
