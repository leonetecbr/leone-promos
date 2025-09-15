@extends('layouts.app')
@section('title', 'Estamos redirecionando você ...')
@section('content')
    <h1 class="display-5 text-center my-5">Estamos redirecionando você ...</h1>
    <p class="text-center">
        Aguarde enquanto te redirecionamos em segurança para a loja onde você poderá adquirir seu produto ...
    </p>
    <div class="progress my-5">
        <div
            id="load"
            class="progress-bar progress-bar-striped progress-bar-animated w-0"
            role="progressbar"
            aria-valuemin="0"
            aria-valuenow="10"
            aria-valuemax="100"
        ></div>
    </div>
@endsection
@section('scripts')
    <script>
        const URL = '{{Request::get('url')}}';

        if (URL === '' || !URL.startsWith('https://')) {
            window.location.href = '/';
        } else {
            let progressBar = document.getElementById('load');
            let progress = 0, url;

            function updateBar() {
                progressBar.classList.remove(`w-${progress}`);
                progress += 25;
                progressBar.classList.add(`w-${progress}`);
                if (progress === 100) {
                    redirect();
                }
            }

            updateBar();

            setTimeout(updateBar, 1000);

            function urlError() {
                alert('Falha ao obter link do produto, tentaremos novamente!');
                document.location.reload();
            }

            function redirect() {
                window.location.href = url;
            }

            (async () => {
                try {
                    const response = await fetch('/redirect', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            'url': URL,
                            '_token': CSRF
                        })
                    });

                    if (!response.ok) {
                        throw new Error('HTTP status ' + response.status);
                    }

                    const data = await response.json();

                    updateBar();

                    if (data.success) {
                        url = data.url;
                        updateBar();
                    } else {
                        urlError();
                    }
                } catch (error) {
                    urlError();
                }
            })();
        }
    </script>
@endsection
