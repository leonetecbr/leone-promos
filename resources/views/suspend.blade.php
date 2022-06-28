
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
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
    <link rel="stylesheet" type="text/css" href="{{ mix('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.min.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Site desativado | {{ env('APP_NAME') }}</title>
    <meta name="description" content="Aproveite as melhores promoções e os melhores cupons das melhores lojas da internet com total segurança!">
    <meta name="og:description" content="Aproveite as melhores promoções e os melhores cupons das melhores lojas da internet com total segurança!">
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
    <meta name="author" content="Leone Oliveira">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://kit.fontawesome.com/6719bc67c5.js" crossorigin="anonymous" async></script>
    <link rel="icon" href="{{ url('/img/icon.png') }}">
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:title" content="Site desativado | {{ env('APP_NAME') }}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Ofertas" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-TileColor" content="#da6709" />
    <meta name="msapplication-TileImage" content="{{ url('/img/icon.png') }}" />
    <link rel="apple-touch-icon" href="{{ url('/img/icon.png') }}" />
    <link rel="manifest" href="{{ url('/json/manifest.json') }}">
    <meta name="application-name" content="Ofertas">
    <link rel="icon" sizes="152x152" href="{{ url('/img/152.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/img/152.png') }}" />
    <link rel="icon" sizes="144x144" href="{{ url('/img/144.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('/img/144.png') }}" />
    <link rel="icon" sizes="128x128" href="{{ url('/img/128.png') }}">
    <link rel="icon" sizes="96x96" href="{{ url('/img/96.png') }}">
    <link rel="icon" sizes="90x90" href="{{ url('/img/90.png') }}">
    <link rel="icon" sizes="72x72" href="{{ url('/img/72.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('/img/72.png') }}" />
    <link rel="icon" sizes="64x64" href="{{ url('/img/64.png') }}">
    <link rel="icon" sizes="60x60" href="{{ url('/img/60.png') }}">
    <link rel="icon" sizes="32x32" href="{{ url('/img/32.png') }}">
    <link rel="icon" sizes="16x16" href="{{ url('/img/16.png') }}">
    <meta name="theme-color" content="#da6709">
    <link rel="canonical" href="{{ Request::url() }}" />
</head>
<body class="h-100 text-center bg-light">
    <header id="cabecalho" class="border border-bottom container-fluid bg-light col-12">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{ route('home') }}" class="navbar-brand" id="logo">
                <h1 class="d-none">{{ env('APP_NAME') }}</h1>
            </a>
        </nav>
    </header>
    <main class="px-3 mt-5 container">
        <h2>Site desativado</h2>
        <p class="lead">Neste momento optamos por manter esse site desativado, o código-fonte
            continua público e acessível a qualquer pessoa que pode remover poucas linhas de código e usá-lo.</p>
        <a href="https://github.com/leonetecbr/leone-promos" class="btn btn-primary text-light btn-lg">Ver no GitHub</a>
    </main>
    @if (env('APP_DEBUG'))
    <div class="container mt-3">
        <p>Parar liberar o site para acesso normal, retire as seguintes linhas do arquivo
            <a href="https://github.com/leonetecbr/leone-promos/blob/main/routes/web.php">web.php</a>:</p>
        <div class="text-start mw-400 mx-auto">
            <pre tabindex="0" class="font-monospace">
// BEGIN Suspensão do funcionamento do site
Route::any('/{uri?}', function($uri = ''){
    return view('suspend');
})->name('home');
// END Suspensão do funcionamento do site
            </pre>
        </div>
    </div>
    @endif
</body>
</html>
