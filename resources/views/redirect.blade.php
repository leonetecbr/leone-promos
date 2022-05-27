@extends('layouts.app')
@section('title', 'Estamos redirecionando você ...')
@section('content')
    <h1 class="display-5 text-center my-5">Estamos redirecionando você ...</h1>
    <p class="text-center">Aguarde enquanto te redirecionamos em segurança para a loja onde você poderá adiquirir seu produto ...</p>
    <div class="progress my-5">
        <div class="progress-bar progress-bar-striped progress-bar-animated w-0" id="load" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
@endsection
@section('scripts')
    <script>
        const URL = '{{Request::get('url')}}'
        if (URL == '' || URL.indexOf('https://') !== 0){
            window.location.href = '/'
        } else{
            let progressBar = document.getElementById('load')
            let progress = 0, url

            function updateBar(){
                progressBar.classList.remove('w-'+progress)
                progress += 25
                progressBar.classList.add('w-'+progress)
                if(progress === 100){
                    redirect()
                }
            }

            updateBar()

            setTimeout(updateBar, 1000)
        
            function urlError(){
                alert('Falha ao obter link do produto, tentaremos novamente!')
                document.location.reload()
            }

            function redirect(){
            window.location.href = url
            }

            $.ajax({
                url: '/redirect',
                data: JSON.stringify({'url': URL, '_token': CSRF}),
                dataType: 'json',
                contentType: 'application/json',
                type: 'POST'
            }).done((data) => {
                updateBar()
        
                if(data.success){
                    url = data.url
                    updateBar()
                }else{
                    return urlError()
                }
            }).fail(urlError)
        }
    </script>
@endsection