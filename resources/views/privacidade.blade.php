@extends('layouts.app')
@section('title', 'Políticas de Privacidade')
@section('keywords', 'Privacidade, Políticas de privacidade, uso dos dados')
@section('description', 'Descubra quais são os dados que temos acesso, como usamos e por que precisamos deles.')
@section('content')
    <article class="container">
        <h1 class="display-5 text-center">Políticas de Privacidade</h1>
        <h2 class="display-6">Introdução</h2>
        <p>A sua privacidade é importante para nós. É política do {{ env('APP_NAME') }} respeitar a sua privacidade em relação a qualquer informação sua que possamos coletar no site <a href="{{ env('APP_URL') }}">{{ env('APP_NAME') }}</a>, e outros sites que possuímos e operamos.</p>
        <p>Solicitamos informações pessoais apenas quando realmente precisamos delas para lhe fornecer um serviço. Fazemos por meios justos e legais, com o seu conhecimento e consentimento. Também informamos por que estamos coletando e como será usado.</p>
        <p>Apenas retemos as informações coletadas pelo tempo necessário para fornecer o serviço solicitado. Quando armazenamos dados, protegemos em meios comercialmente aceitáveis para evitar perdas e roubos, bem como acesso, divulgação, cópia, uso ou modificação não autorizada.</p>
        <p>Não compartilhamos informações de identificação pessoal publicamente ou com terceiros, exceto quando exigido por lei.</p>
        <p>O nosso site pode ter links para sites externos que não são operados por nós. Esteja ciente que não temos controle sobre o conteúdo e práticas desses sites e não podemos aceitar responsabilidade por suas respectivas políticas de privacidade.</p>
        <p>Você é livre para recusar a nossa solicitação de informações pessoais, entendendo que talvez não possamos fornecer alguns dos serviços desejados.</p>
        <p>O uso continuado de nosso site será considerado como aceitação de nossas práticas em torno de privacidade e informações pessoais. Se você tiver alguma dúvida sobre como lidamos com dados do usuário e informações pessoais, entre em contato conosco.</p>
        <h2 class="display-6">Dados coletados</h2>
        <p>Enquanto você acessa nosso site coleta através do Google Analytics dados como formato de tela, navegador, sistema operacional, marca do aparelho, modelo do aparelho, estado, cidade, e atividades suas na página como cliques e rolagens. Estes dados são coletados de forma anônima por nós e não são associados a sua conta do {{ env('APP_NAME') }}, temos como única finalidade analisar o desempenho do nosso site.</p>
        <p>O Google Analytics também coleta dados sobre as visitas e os associa às informações do Google coletadas em outras contas de usuários que fizeram <i>login</i> e permitiram esse vínculo para fins de personalização de anúncios. Essas informações incluem o local do usuário final, o histórico de pesquisa e do YouTube, bem como os dados de sites parceiros do Google. Além disso, elas são usadas para oferecer <i>insights</i> agregados e anônimos sobre o comportamento dos nossos usuários em dispositivos diferentes.</p>
        <p>Dados também podem ser coletados pelo Google AdSense e pelo Google reCAPTCHA, usados para propaganda e para verificação robótica respectivamente, portanto, as <a target="_blank" rel="nofollow" href="https://policies.google.com/privacy">Políticas de Privacidade</a> e <a target="_blank" rel="nofollow" href="https://policies.google.com/terms">Termos de Serviço</a> do Google são aplicáveis.</p>
        <h2 class="display-6">Segurança com seus dados</h2>
        <p>Seus dados são tratados com toda segurança a conexão com seu aparelho é feita apenas em conexões seguras (HTTPS TLS), do lado do servidor, usamos senhas fortes e criptografamos informações sensíveis como senhas e não compartilhamos as informações em nossa posse com terceiros.</p>
        <h2 class="display-6">Solicitação de dados</h2>
        <p>As únicas informações coletadas e identificáveis armazenadas no nosso sistema são as suas preferências de notificação, que podem ser acessadas e alteradas através da página de <a href="{{ route('notificacoes') }}" target="_blank">Gerenciamento de notificações</a></p>
        <h2 class="display-6">Exclusão de dados</h2>
        <p>Como informado acima as únicas informações armazenadas ligadas a você (nesse caso ao seu navegador) são suas preferências de notificação, para excluí-las basta acessar a página de <a href="{{ route('notificacoes') }}" target="_blank">Gerenciamento de notificações</a> e desativa-lás.</p>
        <h2 class="display-6">Leia também</h2>
        <p>Quer saber mais sobre como usamos os cookies? Consulte as nossas <a href="{{ route('cookies') }}">Políticas de Cookies</a>.</p>
        <h2 class="display-6">Mais informações</h2>
        <p>Estas políticas são efetivas a partir de <span class="fw-bolder">Dezembro/2021</span>.</p>
    </article>
@endsection