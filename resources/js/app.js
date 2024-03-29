const options = {
    hour: 'numeric', minute: 'numeric', year: 'numeric', month: '2-digit', day: '2-digit'
}, igShareDiv = $('#ig-share'), notificationInput = $('#notificacao'), allPrefer = $('#all'), prefersDiv = $('#prefers')

const prefersInputs = $("#prefers input[type='checkbox']"), paraInput = $('#para'), preferInputs = $('.prefer')

String.prototype.strstr = function (search) {
    let position = this.indexOf(search)
    if (position === -1) {
        return this
    }
    return this.substring(0, position)
}

let trackSuccess = (data) => {
    if (data.success) {
        let track
        let rastreio = data.track
        let header = '<h2 class="text-center">' + rastreio.codObjeto + '</h2>'
        if (rastreio.eventos.length !== 0) {
            let suspend = true
            track = '<div class="list-group eventos col-12 col-lg-9 mx-auto mt-3">'
            let i = ' active'
            for (let evento of rastreio.eventos) {
                let data = new Intl.DateTimeFormat('pt-BR', options).format(new Date(evento.dtHrCriado))
                if (evento.unidadeDestino && evento.unidadeDestino.endereco.length !== 0) {
                    let text
                    if (evento.unidadeDestino.endereco.cidade !== undefined) {
                        text = 'para ' + evento.unidadeDestino.tipo + ', ' + evento.unidadeDestino.endereco.cidade + ' - ' + evento.unidadeDestino.endereco.uf
                    } else {
                        text = 'para ' + evento.unidadeDestino.tipo + ', ' + evento.unidadeDestino.endereco.uf
                    }
                    evento.descricao = evento.descricao.replace('- por favor aguarde', text)
                }
                if (evento.descricao === 'Objeto encaminhado para retirada no endereço indicado' || evento.descricao === 'Objeto aguardando retirada no endereço indicado') {
                    let number = (typeof evento.unidade.endereco.numero === 'undefined') ? 'S/N' : evento.unidade.endereco.numero
                    evento.detalhe = `${evento.unidade.endereco.logradouro}, ${number} - ${evento.unidade.endereco.bairro}\n<br>\n${evento.unidade.endereco.cidade} - ${evento.unidade.endereco.uf}`
                } else if (!evento.detalhe && evento.unidade.endereco.length !== 0) evento.detalhe = `${evento.unidade.tipo}, ${evento.unidade.endereco.cidade} - ${evento.unidade.endereco.uf}`
                else if (!evento.detalhe && evento.unidade.endereco.length === 0) evento.detalhe = evento.unidade.nome
                if (evento.descricao === 'Objeto entregue ao destinatário' || evento.descricao === 'Objeto saiu para entrega ao destinatário' || evento.descricao === 'Distribuído ao remetente.' || evento.descricao === 'Objeto saiu para entrega ao remetente') suspend = false
                track += `<a href="#" class="list-group-item list-group-item-action${i}"><div class="evento d-flex w-100 justify-content-between">`
                track += `<h5 class="mb-1">${evento.descricao}</h5><small>${data}</small>`
                track += `</div><p class="mb-1">${evento.detalhe}</p></a>`
                i = ''
            }
            track += '</div>'
            if (suspend && rastreio.dtPrevista !== '') {
                let date = new Date(rastreio.dtPrevista)
                header += '\n<div class="text-center small fw-bolder">PREVISÂO DE ENTREGA: ' + date.toLocaleDateString() + '*</div>'
                track += '\n<div class="text-center small my-2">*A previsão de entrega é fornecida pelos Correios e, em geral a entrega costuma acontecer bem antes da previsão.</div>\n<div class="mx-auto mt-3 w-75"><a href="https://rastreamento.correios.com.br/app/suspensaoEntrega/index.php?objeto=' + rastreio.codObjeto + '" target="_blank"><button class="btn btn-danger text-light btn-lg w-100">Suspender entrega</button></a></div>'
            }
            header += '\n<div class="text-center small fw-light">' + rastreio.tipoPostal + '</div>'
        } else {
            track = '<div class="alert alert-warning">Aguardando postagem do objeto.</div>'
        }
        $('#rastreamento').html(header + track)
        window.location.href = '#rastreamento'
    } else if (data.message !== undefined) {
        $('#error-track').html('<div class="alert alert-danger">' + data.message + '</div>').removeClass('d-none')
    }
}

function igShare(element) {
    let title = $(element).find('.product-title').html()
    let desc = $(element).find('.description').html()
    let priceFrom = $(element).find('.price-from').html()
    let code = $(element).find('.code-text').val()
    $('#product-title').html(title)
    $('#product-image').attr('src', $(element).find('.product-image').attr('src')).attr('alt', title)
    if (priceFrom !== undefined) {
        $('#product-price-from').html(priceFrom)
        $('#price-from').show()
    } else {
        $('#price-from').hide()
    }
    $('#installment').html($(element).find('.installment').html())
    if (desc !== undefined) {
        $('#product-desc').html(desc).show()
    } else {
        $('#product-desc').hide()
    }
    if (code !== undefined) {
        $('#product-code').show()
    } else {
        $('#product-code').hide()
    }
    $('#product-price-to').html($(element).find('.pricing-card-title').html())
    $('#share-link').html(getUrl(element))
    igShareDiv.removeClass('d-none')
}

function escondeCupom(cupom) {
    cupom = String(cupom)
    let code = cupom.substring(0, cupom.length - 2)
    return code.replace(/./g, '*') + cupom.substring(cupom.length - 2)
}

function getText(element) {
    let desc = $(element).find('.description').html()
    let text = $(element).find('.pricing-card-title').html()
    let priceFrom = $(element).find('del').html()
    let title = $(element).find('.product-title').html()
    let cupom = $(element).find('.code-text').val()

    if (text !== 'Grátis') {
        text = `Por apenas ${text}!`
    }

    if (priceFrom !== undefined) {
        text = `De: ${priceFrom}\n\n${text}`
    }

    if (cupom !== undefined) {
        text += '\n\nCupom: ' + escondeCupom(cupom)
    }

    text = `${title}.\n\n${text}`

    if (desc !== undefined) {
        text += `\n\n${desc}`
    }

    return text
}

function getTextCupom(element) {
    let text = $(element).find('.card-title').html() + ' no(a) ' + $(element).find('.loja-image').attr('alt')
    let vigency = $(element).find('.cupom-vigency').html()
    let cupom = $(element).find('.code-text').val()

    cupom = 'Cupom: ' + escondeCupom(cupom)

    text += `\n\n${vigency}\n\n${cupom}`

    return text
}

function getUrl(element) {
    return 'https://para.promo/' + btoa(element.replace('#promo-', 'o-')).replace('=', '')
}

function getUrlCupom(element) {
    return 'https://para.promo/' + btoa(element.replace('#cupom-', 'c-')).replace('=', '')
}

function copyText(text, url = false) {
    navigator.clipboard.writeText(text).then(() => {
        if (url) window.open(url)
        else {
            let toast = new bootstrap.Toast(document.getElementById('copy-success'))
            toast.show()
        }
    }, () => {
        if (url) window.open(url)
        else errorAlert('Não foi possível copiar, copie manualmente!')
    })

}

function topo() {
    $('html, body').animate({scrollTop: 0}, 800)
}

function getReCaptcha(token) {
    let input = document.createElement('input')
    input.setAttribute('type', 'hidden')
    input.id = 'g-recaptcha-response'
    input.setAttribute('name', 'g-recaptcha-response')
    input.value = token
    return input
}

function redirectUrl() {
    let textBox = $('#url')
    let url = textBox.val()
    url = url.strstr('?')
    window.open(`/redirect?url=${url}`)
    textBox.val('')
}

function pesquisar(q, token) {
    let csrf = getCSRF()
    let recaptcha = getReCaptcha(token)
    let form = document.createElement('form')
    form.setAttribute('method', 'POST')
    form.setAttribute('action', `/search/${q}`)
    form.id = 'pesquisar'
    form.appendChild(csrf)
    form.appendChild(recaptcha)
    $('body').append(form)
    $('#pesquisar').trigger('submit')
}

function paginateSearch(href, token) {
    let csrf = getCSRF()
    let recaptcha = getReCaptcha(token)
    let form = document.createElement('form')
    form.setAttribute('method', 'POST')
    form.setAttribute('action', `${href}`)
    form.id = 'pesquisar'
    form.appendChild(csrf)
    form.appendChild(recaptcha)
    $('body').append(form)
    $('#pesquisar').trigger('submit')
}

function sendForm(id, token, onSuccess) {
    if (onSuccess === undefined) {
        onSuccess = (data) => {
            if (typeof data.success === undefined) {
                $(errorId).html('<p class="alert alert-danger">Erro desconhecido :(</p>')
                $(errorId).removeClass('d-none')
            } else if (typeof data.message !== undefined) {
                if (!data.success) {
                    $(errorId).html('<p class="alert alert-danger">' + data.message + '</p>')
                    $(errorId).removeClass('d-none')
                } else {
                    $(errorId).html('<div class="alert alert-success">' + data.message + '</div>')
                    $(errorId).removeClass('d-none')
                }
            }
        }
    }

    let valores = {}
    let form = $(`#${id}`)
    for (let valor of form.serializeArray()) {
        valores[valor.name] = valor.value
    }
    valores['_token'] = CSRF
    valores['g-recaptcha-response'] = token
    let btn = $(`#${id}-submit`)
    let value = btn.html()
    let errorId = `#error-${id}`
    btn.attr('disabled', true)
    btn.html('Aguarde ...')
    form.removeClass('was-validated')
    $(errorId).addClass('d-none')
    $.ajax({
        url: form.attr('action'),
        data: JSON.stringify(valores),
        dataType: 'json',
        contentType: 'application/json',
        type: 'POST'
    })
        .done(onSuccess)
        .fail(() => {
            $(errorId).html('<p class="alert alert-danger">Não foi possível enviar os dados, tente novamente!</p>')
            $(errorId).removeClass('d-none')
        })
        .always(() => {
            btn.html(value)
            btn.attr('disabled', false)
        })
}

function getToken(action, id, type = 'ajax') {
    let text, btn, changeBtn = false
    if (type === 'ajax' || type === 'track') changeBtn = true

    if (changeBtn) {
        btn = $(`#${id}-submit`)
        text = btn.html()
        btn.html('Verificando ...').attr('disabled', true)
    }

    let interval = setInterval(function () {
        if (window.grecaptcha) {
            clearInterval(interval)
            grecaptcha.ready(() => {
                grecaptcha.execute(KEY_V3_RECAPTCHA, {action: action})
                    .then((token) => {
                        if (changeBtn) {
                            btn.html(text)
                        }

                        if (type === 'ajax') {
                            sendForm(id, token)
                        } else if (type === 'search') {
                            let q = $('#q').val()
                            pesquisar(q, token)
                        } else if (type === 'paginate') {
                            paginateSearch(id, token)
                        } else if (type === 'track') {
                            sendForm(id, token, trackSuccess)
                        }
                    })
            })
        }
    }, 100)
}

function getData(e) {
    let element, text, url
    if (($(e).closest('.promo').attr('id') !== undefined)) {
        element = '#' + $(e).closest('.promo').attr('id')
        text = getText(element)
        url = getUrl(element)
    } else {
        element = '#' + $(e).closest('.cupom').attr('id')
        text = '\n' + getTextCupom(element)
        url = getUrlCupom(element)
    }
    return {'url': url, 'text': text}
}

$('.ajax-form').on('submit', function (e) {
    if (!this.checkValidity()) {
        e.preventDefault()
        e.stopPropagation()
    } else {
        e.preventDefault()
        let action = $(this).attr('data-action')
        if (action === 'search') getToken(action, this.id, action)
        else getToken(action, this.id)
    }
    this.classList.add('was-validated')
})

$('.needs-validation').on('submit', function (e) {
    if (this.checkValidity() === false) {
        e.preventDefault()
        e.stopPropagation()
        $(this).addClass('was-validated')
    } else {
        e.preventDefault()
        $(this).addClass('was-validated')
        if (this.id === 'deeplink') {
            redirectUrl()
        } else if (this.id === 'track') {
            getToken('rastrear', this.id, 'track')
        }
        $(this).removeClass('was-validated')
    }
})

if (navigator.share) {
    $('.plus-share').removeClass('d-none')
}

$('#accept').on('click', () => {
    createCookie('accept', 'true', 365)
    $('#aviso-cookie').fadeOut('slow')
})

$('.igs').on('click', function () {
    alert('Tire print e compartilhe nas suas stories, para fechar dê um duplo clique!')
    igShare('#' + $(this).closest('.promo').attr('id'))
})

$('.mre').on('click', function () {
    let {text, url} = getData(this)

    navigator.share({
        text: text,
        url: url,
    })
})

$('.cpy').on('click', function () {
    let {text, url} = getData(this)
    text += `\n\n${url}`

    copyText(text)
})

$('.wpp').on('click', function () {
    let {text, url} = getData(this)
    text += `\n\n${url}`

    window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text))
})

$('.tlg').on('click', function () {
    let {text, url} = getData(this)

    window.open('https://telegram.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text))
})

$('.twt').on('click', function () {
    let {text, url} = getData(this)
    text += '\n'

    window.open('https://twitter.com/share?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text))
})

igShareDiv.on('dblclick', () => igShareDiv.addClass('d-none'))

$('.copy-redirect').on('click', function () {
    let element = $(this).closest('.promo').attr('id')
    element = (element === undefined) ? '#' + $(this).closest('.cupom').attr('id') : '#' + element
    let url = $(this).attr('data-link')
    let code = $(element).find('.code-text').val()
    copyText(code, url)
})

$(window).on('scroll', () => {
    let nav = $('#cabecalho')
    let maxScroll = (window.screen.width < 768) ? 61 : 116
    if ($(window).scrollTop() > maxScroll) {
        $('body').css('padding-top', maxScroll)
        nav.addClass('fixed-top')
        nav.addClass('shadow')
    } else {
        $('body').css('padding-top', 0)
        nav.removeClass('fixed-top')
        nav.removeClass('shadow')
    }
})

$('#i-notification').on('click', () => {
    $('#notification').addClass('d-none')
    createCookie('no_notification', 1, 60)
})

if (window.location.pathname.indexOf('/search') === 0) {
    $('.page-link').on('click', function (e) {
        e.preventDefault()
        let href = $(this).attr('href')
        getToken('paginate', href, 'paginate')
    })

    $('.filtros').on('click', function (e) {
        e.preventDefault()
        getToken('paginate', $(this).attr('href'), 'paginate')
    })
}

prefersInputs.on('change', function () {
    if (prefersInputs.is(':checked')) {
        if ((this.id === 'all' && $(this).is(':checked')) || this.id !== 'all') {
            return paraInput.attr('disabled', true).removeAttr('required')
        }
    }
    paraInput.attr('disabled', false).attr('required')
})

allPrefer.on('change', () => preferInputs.prop('checked', allPrefer.is(':checked')))

notificationInput.on('change', () => {
    if (notificationInput.is(':checked')) {
        prefersDiv.removeClass('d-none').addClass('d-md-flex')
        prefersInputs.prop('checked', true)
    } else {
        prefersDiv.addClass('d-none')
        prefersInputs.prop('checked', false)
    }
})

preferInputs.on('change', function () {
    let all = true
    for (check of preferInputs) {
        if (!$(check).is(':checked')) {
            all = false
        }
    }

    $('#all').prop('checked', all)
})

$('#btn-topo').on('click', topo)
