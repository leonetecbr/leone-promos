@extends('layouts.app')
@section('title', 'Políticas de Cookies')
@section('keywords', 'políticas de cookies, cookies, uso dos dados')
@section('description', 'Descubra como, por que e quais são os cookies usamos para rastrear sua navegação no nosso site.')
@section('content')
    <article class="container">
        <h1 class="display-5 text-center">Políticas de Cookies</h1>
        <h2 class="display-6">O que são cookies?</h2>
        <p>Como é prática comum em quase todos os sites profissionais, este site usa cookies, pequenos arquivos baixados
            no seu computador, para melhorar sua experiência. Esta página descreve quais informações eles armazenam,
            como os usamos e por que às vezes precisamos armazenar esses cookies. Também compartilharemos como você pode
            impedir que esses cookies sejam armazenados, no entanto, isso pode fazer o <i>downgrade</i> ou 'quebrar'
            certos elementos da funcionalidade do site.</p>
        <h2 class="display-6">Como usamos os cookies?</h2>
        <p>Utilizamos cookies por vários motivos, detalhados abaixo. Infelizmente, geralmente, não existem opções padrão
            do setor para desativar os cookies sem desativar completamente a funcionalidade e os recursos que eles
            adicionam a este site. É recomendável que você deixe todos os cookies se não tiver certeza se precisa ou não
            deles, caso sejam usados para fornecer um serviço que você usa.</p>
        <h2 class="display-6">Desativar cookies</h2>
        <p>Você pode impedir a configuração de cookies ajustando as configurações do seu navegador (consulte a Ajuda do
            navegador para saber como fazer isso). Esteja ciente que a desativação de cookies afetará a funcionalidade
            deste e de muitos outros sites que você visita. A desativação de cookies geralmente resultará na desativação
            de determinadas funcionalidades e recursos deste site. Portanto, é recomendável que você não desative os
            cookies.</p>
        <h2 class="display-6">Cookies que definimos</h2>
        <ul>
            <li>
                <p class="fw-bolder">Cookies de preferências do site</p>
                <p>Para proporcionar uma ótima experiência neste site, fornecemos a funcionalidade para definir suas
                    preferências de como esse site é executado quando você o usa. Para lembrar suas preferências,
                    precisamos definir cookies para que essas informações possam ser chamadas sempre que você interagir
                    com uma página for afetada por suas preferências, entre elas o aceite de políticas de privacidade e
                    de cookies.</p>
            </li>
            <li>
                <p class="fw-bolder">Cookies de segurança</p>
                <p>São cookies que servem para proteger nossos usuários de ataques CSRF, sigla em inglês para <span
                        class="fw-bolder">Falsificação de solicitação entre sites.</span></p>
            </li>
            <li>
                <p class="fw-bolder">Cookies de sessão</p>
                <p>São usados para guardar sua sessão, por exemplo, quando você faz <i>login</i>, não é necessário você
                    digitar sua senha a cada ação, porque o <i>cookie</i> de sessão já identifica você.</p>
            </li>
        </ul>
        <h2 class="display-6">Cookies de Terceiros</h2>
        <p>Em alguns casos especiais, também usamos cookies fornecidos por terceiros confiáveis. A seção a seguir
            detalha quais cookies de terceiros você pode encontrar através deste site.</p>
        <ul>
            <li>Este site usa o Google Analytics, uma das soluções de análise mais difundidas e confiáveis da Web, para
                nos ajudar a entender como você usa o site e como podemos melhorar sua experiência. Esses cookies podem
                rastrear itens como quanto tempo você gasta no site e as páginas visitadas, para podermos continuar
                produzindo conteúdo atraente.<br><br> As análises de terceiros são usadas para rastrear e medir o uso
                deste site, para podermos continuar produzindo conteúdo atrativo. Esses cookies podem rastrear itens
                como o tempo que você passa no site ou as páginas visitadas, o que nos ajuda a entender como podemos
                melhorar o site para você.
            </li>
        </ul>
        <p>Para mais informações sobre cookies do Google Analytics, consulte a página oficial do Google Analytics.</p>
        <ul>
            <li>O serviço Google AdSense que usamos para veicular publicidade usa um <i>cookie</i> DoubleClick para
                veicular anúncios mais relevantes em toda a Web e limitar o número de vezes que um determinado anúncio é
                exibido para você.<br>Para mais informações sobre o Google AdSense, consulte as FAQs oficiais sobre
                privacidade do Google AdSense.<br/><br>Utilizamos anúncios para compensar os custos de funcionamento
                deste site e fornecer financiamento para futuros desenvolvimentos. Os cookies de publicidade
                comportamental usados por este site foram projetados para garantir que você forneça os anúncios mais
                relevantes sempre que possível, rastreando anonimamente seus interesses e apresentando coisas
                semelhantes que possam ser do seu interesse.
            </li>
        </ul>
        <h2 class="display-6">Leia também</h2>
        <p>Quer saber mais sobre como usamos os dados que temos acesso ou como você pode excluir seus dados? Consulte as
            nossas <a href="{{ route('privacidade') }}">Políticas de Privacidade</a>.</p>
        <h2 class="display-6">Mais informações</h2>
        <p>Esperemos que esteja esclarecido e, como mencionado anteriormente, se houver algo que você não tem certeza se
            precisa ou não, geralmente é mais seguro deixar os cookies ativados, caso interaja com um dos recursos que
            você usa em nosso site.</p>
        <p>Estas políticas são efetivas a partir de <span class="fw-bolder">Dezembro/2021</span>.</p>
    </article>
@endsection
