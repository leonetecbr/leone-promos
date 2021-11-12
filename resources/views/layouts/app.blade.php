<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  @if (!env('APP_DEBUG'))
  <!--script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ env('SITE_ID_ADSENSE') }}" crossorigin="anonymous"></-script-->
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
  <link rel="stylesheet" type="text/css" href="{{ url(mix('css/bootstrap.css')) }}" />
  <link rel="stylesheet" type="text/css" href="{{ url(mix('css/app.css')) }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <title>@yield('title') | {{ env('APP_NAME') }}</title>
  @hasSection('description')
  <meta name="description" content="@yield('description')">
    <meta name="og:description" content="@yield('description')">
  @else
  <meta name="description" content="Aproveite as melhores promoções e os melhores cupons das melhores lojas da internet com total segurança!">
  <meta name="og:description" content="Aproveite as melhores promoções e os melhores cupons das melhores lojas da internet com total segurança!">
  @endif
  @hasSection('keywords')
  <meta name="keywords" content="@yield('keywords')">
  @endif
  <meta name="robots" content="{{ $robots??'index, follow' }}">
  <meta name="author" content="Leone Oliveira">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <script src="https://kit.fontawesome.com/6719bc67c5.js" crossorigin="anonymous" async></script>
  <link rel="icon" href="/img/icon.png">
  <meta property="og:locale" content="pt_BR" />
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
  <meta property="og:url" content="{{ Request::url() }}" />
  <meta property="og:title" content="@yield('title') | {{ env('APP_NAME') }}" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="Ofertas" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="msapplication-TileColor" content="#ce2e3c" />
  <meta name="msapplication-TileImage" content="/img/icon.png" />
  <link rel="apple-touch-icon" href="/img/icon.png" />
  <link rel="manifest" href="/json/manifest.json">
  <meta name="application-name" content="Ofertas">
  <link rel="icon" sizes="152x152" href="/img/152.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/img/152.png" />
  <link rel="icon" sizes="144x144" href="/img/144.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/img/144.png" />
  <link rel="icon" sizes="128x128" href="/img/128.png">
  <link rel="icon" sizes="96x96" href="/img/96.png">
  <link rel="icon" sizes="90x90" href="/img/90.png">
  <link rel="icon" sizes="72x72" href="/img/72.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/img/72.png" />
  <link rel="icon" sizes="64x64" href="/img/64.png">
  <link rel="icon" sizes="60x60" href="/img/60.png">
  <link rel="icon" sizes="32x32" href="/img/32.png">
  <link rel="icon" sizes="16x16" href="/img/16.png">
  <meta name="theme-color" content="#ce2e3c">
  <link rel="canonical" href="{{ Request::url() }}" />
  <script src="https://www.google.com/recaptcha/api.js?render={{ env('PUBLIC_RECAPTCHA_V3') }}" async></script>@yield('headers')
</head>

<body>
  @if (empty($_COOKIE['accept']))
  <section class="fixed-bottom bg-primary col-12 col-md-9 col-lg-8 mx-auto mb-md-3 text-light p-3" id="aviso_cookie">
    <div class="mb-2">Esse site utiliza cookies te dá uma melhor experiência de navegação. <a href="{{ route('cookies') }}" target="_blank" class="text-light">Saiba mais &raquo;</a></div>
    <div class="text-end">
      <button class="btn btn-outline-light" id="accept" onclick="accept()">Fechar e aceitar</button>
    </div>
  </section>
  @endif
  <header id="cabecalho" class="d-flex justify-content-between p-3 border border-bottom bg-white">
    <div>
      <a href="/" class="navbar-brand">
        <div id="logo" class="h-100"></div>
        <!--img src="/img/logo.png" alt="Leone Promos" id="logo"--> 
        <{{ (Route::currentRouteName()=='home')?'h1':'span'; }} class="d-none">{{ env('APP_NAME') }}</{{ (Route::currentRouteName()=='home')?'h1':'span'; }}>
      </a>
    </div>
    <div class="d-flex justify-content-around">
      <button id="btn-menu" class="bg-white d-md-none border-0 h-100 me-3"><i class="fas fa-bars"></i></button>
      <nav class="navbar navbar-expand-md navbar-light d-md-block d-none me-md-4 bg-white w-100 w-md-auto h-md-auto h-100" id="menu">
        <button class="btn rounded btn-outline-danger d-md-none" id="close"><i class="fas fa-times fs-1"></i></button>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a href="{{ (Route::currentRouteName()=='home')?'#':route('home') }}" class="nav-link{{ (Route::currentRouteName()=='home')?' active':''; }}">Início</a></li>
          <li class="nav-item"><a href="{{ (Route::currentRouteName()=='cupons')?'#':route('cupons') }}" class="nav-link{{ (Route::currentRouteName()=='cupons')?' active':''; }}">Cupons</a></li>
          <li class="nav-item"><a href="{{ (Route::currentRouteName()=='lojas')?'#':route('lojas') }}" class="nav-link{{ (Route::currentRouteName()=='lojas')?' active':''; }}">Lojas</a></li>
          <li class="nav-item"><a href="{{ (Route::currentRouteName()=='categorias')?'#':route('categorias') }}" class="nav-link{{ (Route::currentRouteName()=='categorias')?' active':''; }}">Categorias</a></li>
          <li class="nav-item"><a href="{{ (Route::currentRouteName()=='notificacoes')?'#':route('notificacoes') }}" class="nav-link{{ (Route::currentRouteName()=='notificacoes')?' active':''; }}">Notificações</a></li>
        </ul>
      </nav>
      <form id="search-lg" class="d-none d-lg-flex justify-content-between needs-validation col-4 me-3" action="#" novalidate>
        <div class="me-2"><input class="form-control mt-2" type="search" placeholder="Pesquisar" minlength="3" maxlength="20" required aria-label="Pesquisar" value="{{ $query??'' }}" name="q" id="ql"></div>
        <div><button class="btn btn-outline-success mt-2" type="submit"><i class="fas fa-search"></i></button></div>
      </form>
      <label for="qs"><button id="btn-search" class="bg-white border-0 h-100 d-lg-none"><i class="fas fa-search"></i></button></label>
      @if (Auth::check())
      <a href="/logout" class="mt-md-2 ms-3"><button id="btn-logout" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt"></i></button></a>
      @endif
    </div>
  </header>
  @if (empty($_COOKIE['no_notify']) && (Request::route()->getName()!='notificacoes'))
  <div id="notify" class="container d-none border-bottom p-3">
    <p>Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador!</p><br />
    <div class="float-end me-2" id="inotify"><i class="fw-bolder far fa-eye-slash pointer"></i></div>
    <div class="text-center"><button id="btn-notify" class="btn btn-primary text-light" disabled="true">Ativar notificações</button></div>
  </div>
  @endif
  <form action="#" id="search" class="d-none d-lg-none needs-validation p-3" method="post" novalidate>
    <div class="row mb-3">
      <div class="col-10 col-sm-11">
        <input type="search" name="q" id="qs" placeholder="Digite sua pesquisa ..." class="form-control" required autocomplete="off" value="{{ $query??'' }}" />
      </div>
      <div class="col-1"><button type="submit" class="btn btn-outline-success"><i class="fas fa-search"></i></button></div>
    </div>
    <div class="invalid-feedback">Pesquisa inválida (Mínimo de 3 caracteres e máximo 20)</div>
    <p class="small">Esta pesquisa é protegida pelo Google reCAPTCHA para garantir que você não é um robô. <a target="_blank" rel="nofollow" href="https://policies.google.com/privacy">Políticas de Privacidade</a> e <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos de Serviço</a> do Google são aplicáveis.
    <p>
  </form>
  <div class="container mt-3 p-3 alert-success d-none" id="copy_sucess">
    <h6 class="bolder">Texto copiado! <i class="fas fa-check"></i></h6>
    <p>Agora é só compartilhar com seus amigos.</p>
  </div>
  <main class="p-3 px-md-5">
    @yield('content')
  </main>
  <div class="wp-button rounded-circle text-light float-end text-center">
    <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}" target="_blank" rel="nofollow" id="btn-whatsapp">
      <i class="fab fa-whatsapp"></i>
    </a>
</div>
  <script>
    var csrf = '{{ csrf_token() }}';
    const KeyV3Recaptcha = '{{ env("PUBLIC_RECAPTCHA_V3") }}';
    const applicationServerPublicKey = '{{ env("VAPID_PUBLIC_KEY") }}';
  </script>
  <script src="{{ url(mix('js/jquery.js')) }}"></script>
  <script src="{{ url(mix('js/bootstrap.js')) }}"></script>
  <script src="{{ url(mix('js/app.js')) }}"></script>
  <footer id="rodape" class="text-center border-top p-3 mt-3">
    <div id="social" class="mx-auto fs-2 mb-3">
      <a href="https://wa.me/message/D3HHIY2QZGOMH1"><i class="fab fa-whatsapp-square"></i></a>
      <a href="https://instagram.com/ofertas.leone"><i class="fab fa-instagram-square"></i></a>
      <a href="https://facebook.com/ofertas.leone"><i class="fab fa-facebook-square"></i></a>
      <a href="https://github.com/leonetecbr/leone-promos/"><i class="fab fa-github-square"></i></a>
    </div>
    <div id="copyright" class="fs-6 fw-light">
      <p>Ao abrir ou comprar um produto mostrado aqui no site, algumas lojas poderam nos pagar uma comissão, mas isso não influencia em quais promoções são postadas por aqui. Em caso de divergência no preço, o preço válido é o da loja. Somos apenas um canal que te ajuda a encontrar o menor preço, não somos loja!</p>
      <p><span class="fw-bolder">&copy; {{ date('Y') }} - {{ env('APP_NAME') }}</span> - Todos os direitos reservados.</p>
    </div>
    <p class="fs-6"><span class="bolder">Políticas: </span> <a href="/privacidade" target="_blank" class="text-decoration-none">de Privacidade</a> | <a href="/cookies" target="_blank" class="text-decoration-none">de Cookies</a></p>
  </footer>
</body>

</html>