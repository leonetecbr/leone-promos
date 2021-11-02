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
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/style.css" />
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
  <div id="ig-share" class="d-none">
    <div id="logomarca">
      <img src="/img/logo.png" alt="Logo">
    </div>
    <img id="product-image" class="mt-2" alt="Imagem do produto">
    <h4 class="h4" id="product-title"></h4>
    <div class="mt-2 fs-12">
      <div id="price-from"><small id="top">De:</small> <del id="product-price-from"></del></div>
      <small id="top2">Por:</small><span class="fs-20 bolder" id="product-price-to"></span>
      <p id="installment"></p>
    </div>
    <div id="product-desc" class="mt-2"></div>
    <div id="product-code" class="mt-2 code"><input type="text" disabled="true" value="Acesse o link para obter o cupom" class="w100 center"></div>
    <p id="share-link" class="mt-3"></p>
  </div>
  @if (empty($_COOKIE['accept']))
  <section class="aviso_eu_cookie">
    <p>Esse site utiliza cookies e coleta alguns dados. Ao continuar a usar este site, você concorda com isso.</p>
    <p>Para saber mais, inclusive sobre quais dados são coletados, consulte aqui:
      <a href="/cookies" target="_blank">
        Políticas de cookies</a> e <a href="/privacidade" target="_blank">
        Políticas de privacidade</a>.
    </p>
    <div id="div_accept">
      <button class="right" id="accept" onclick="accept()">Fechar e aceitar</button>
    </div>
  </section>
  @endif
  <header id="cabecalho" class="d-flex justify-content-between p-3 border border-bottom">
    <div>
      <a href="/" class="navbar-brand">
        <div id="logo" class="h-100"></div>
        <!--img src="/img/logo.png" alt="Leone Promos" id="logo"--> 
        <{{ (Request::route()->getName()=='home')?'h1':'span'; }} class="d-none">{{ env('APP_NAME') }}</{{ (Request::route()->getName()=='home')?'h1':'span'; }}>
      </a>
    </div>
    <div class="d-flex justify-content-around">
      <button id="btn-menu" class="bg-white d-md-none border-0 w-100 me-3"><i class="fas fa-bars"></i></button>
      @if (Auth::check())
      <a href="/logout"><button id="btn-logout" class="bg-white"><i class="fas fa-sign-out-alt"></i></button></a>
      @endif
      <nav class="navbar navbar-expand navbar-light d-md-block d-none me-4">
        <a id="close"><i class="fas fa-times d-md-none"></i></a>
        <ul class="navbar-nav">
          <li class="nav-item"><a href="{{ (Request::route()->getName()=='home')?'#':route('home') }}" class="nav-link{{ (Request::route()->getName()=='home')?' active':''; }}">Início</a></li>
          <li class="nav-item"><a href="{{ (Request::route()->getName()=='cupons')?'#':route('cupons') }}" class="nav-link{{ (Request::route()->getName()=='cupons')?' active':''; }}">Cupons</a></li>
          <li class="nav-item"><a href="{{ (Request::route()->getName()=='lojas')?'#':route('lojas') }}" class="nav-link{{ (Request::route()->getName()=='lojas')?' active':''; }}">Lojas</a></li>
          <li class="nav-item"><a href="{{ (Request::route()->getName()=='categorias')?'#':route('categorias') }}" class="nav-link{{ (Request::route()->getName()=='categorias')?' active':''; }}">Categorias</a></li>
          <li class="nav-item"><a href="{{ (Request::route()->getName()=='notificacoes')?'#':route('notificacoes') }}" class="nav-link{{ (Request::route()->getName()=='notificacoes')?' active':''; }}">Notificações</a></li>
        </ul>
      </nav>
      <form class="d-none d-lg-flex justify-content-between">
        <div class="me-2"><input class="form-control mt-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar"></div>
        <div><button class="btn btn-outline-success mt-2" type="submit"><i class="fas fa-search"></i></button></div>
      </form>
      <label for="qs"><button id="btn-search" class="bg-white border-0 h-100 d-lg-none"><i class="fas fa-search"></i></button></label>
    </div>
  </header>
  @if (empty($_COOKIE['no_notify']) && (Request::route()->getName()!='notificacoes'))
  <div id="notify" class="container d-none">
    <p>Receba nossas seleção de melhores promoções em primeira mão por notificação no seu navegador!</p><br />
    <div class="center"><button id="btn-notify" class="btn-static bg-orange radius" disabled="true">Ativar notificações</button></div>
    <div class="right mt-2" id="inotify"><i class="bolder far fa-eye-slash"></i></div>
  </div>
  @endif
  <form action="/search" id="form" class="d-none" method="post">
    <input type="search" name="q" id="qs" placeholder="Digite sua pesquisa ..." class="radius bg-black" required autocomplete="off" value="{{ $query??'' }}" />
    <button type="submit" class="bg-gradiente" onclick="event.preventDefault();validate_search();"><i class="fas fa-search"></i></button>
    <div class="small erro iqs center padding d-none">Pesquisa inválida (Mínimo de 3 caracteres e máximo 64)</div>
    <p class="small padding bg-white">Esta pesquisa é protegida pelo Google reCAPTCHA para garantir que você não é um robô. <a target="_blank" rel="nofollow" href="https://policies.google.com/privacy">Políticas de Privacidade</a> e <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos de Serviço</a> do Google são aplicáveis.
    <p>
  </form>
  <div class="container d-none" id="copy_sucess">
    <h6 class="bolder">Texto copiado! <i class="fas fa-check"></i></h6>
    <p>Agora é só compartilhar com seus amigos.</p>
  </div>
  <main class="container-lg">
    @yield('content')
  </main>
  <a href="https://wa.me/message/D3HHIY2QZGOMH1" target="_blank" rel="nofollow" id="btn-whatsapp">
    <div><i class="fab fa-whatsapp"></i>
    </div>
  </a>
  <script>
    var csrf = '{{ csrf_token() }}';
  </script>
  <script src="/js/jquery.min.js"></script>
  <script src="/js/popper.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/funcoes.js"></script>
  <script src="/js/notify.js"></script>
  <footer id="rodape" class="container center bg-gradiente">
    <div id="social">
      <a href="https://wa.me/message/D3HHIY2QZGOMH1"><i class="fab fa-whatsapp-square"></i></a>
      <a href="https://instagram.com/ofertas.leone"><i class="fab fa-instagram-square"></i></a>
      <a href="https://facebook.com/ofertas.leone"><i class="fab fa-facebook-square"></i></a>
      <a href="https://github.com/leonetecbr/leone-promos/"><i class="fab fa-github-square"></i></a>
    </div>
    <p id="copyright" class="fs-1">Ao abrir ou comprar um produto mostrado aqui no site, algumas lojas poderam nos pagar uma comissão, mas isso não influencia em quais promoções são postadas por aqui. Em caso de divergência no preço, o preço válido é o da loja. Somos apenas um canal que te ajuda a encontrar o menor preço, não somos loja!<br /><br />
      <span class="bolder">&copy; {{ date('Y') }} - {{ env('APP_NAME') }}</span> - Todos os direitos reservados.
    </p>
    <p class="fs-1"><span class="bolder">Políticas: </span> <a href="/privacidade" target="_blank">de Privacidade</a> | <a href="/cookies" target="_blank">de Cookies</a></p>
  </footer>
</body>

</html>