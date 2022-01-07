String.prototype.strstr = function (search) {
  let position = this.indexOf(search)
  if (position == -1) {
    return this
  }
  return this.substring(0, position)
}

function igShare(element) {
  let title = $(element).find('.product-title').html()
  let desc = $(element).find('.description').html()
  let priceFrom = $(element).find('del').html()
  let code = $(element).find('.code-text').val()
  $('#product-title').html(title)
  $('#product-image').attr('src', $(element).find('.product-image').attr('src'))
  $('#product-image').attr('alt', title)
  if (priceFrom !== undefined) {
    $('#product-price-from').html(priceFrom)
    $('#price-from').show()
  } else {
    $('#price-from').hide()
  }
  $('#installment').html($(element).find('.installment').html())
  if (desc !== undefined) {
    $('#product-desc').html(desc)
    $('#product-desc').show()
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
  $('#ig-share').removeClass('d-none')
}

function getText(element) {
  let desc = $(element).find('.description').html()
  let text = $(element).find('.pricing-card-title').html()
  let priceFrom = $(element).find('del').html()
  let title = $(element).find('.product-title').html()

  if (text !== 'Grátis') {
    text = `Por apenas: ${text}`
  }

  if (priceFrom !== undefined) {
    text = `De: ${priceFrom}\n\n${text}`
  }

  text = `${title}.\n\n${text}!`

  if (desc !== undefined) {
    text += `\n\n${desc}`
  }

  return text
}

function getTextCupom(element) {
  let text = $(element).find('.card-title').html() + ' no(a) ' + $(element).find('.loja-image').attr('alt')
  let vigency = $(element).find('.cupom-vigency').html()
  let cupom = String($(element).find('.code-text').val())
  let code = cupom.substring(0, cupom.length - 2)

  cupom = 'Cupom: ' + code.replace(/\w/g, '*') + cupom.substr(-2)

  text += `\n\n${vigency}\n\n${cupom}`

  return text
}

function getUrl(element) {
  return 'https://para.promo/' + btoa(element.replace('#promo-', 'o-'))
}

function getUrlCupom(element) {
  return 'https://para.promo/' + btoa(element.replace('#cupom-', 'c-'))
}

function accept() {
  createCookie('accept', 'true', 365)
  $('#aviso_cookie').fadeOut('slow')
}

function copyText(text, url = false){
  navigator.clipboard.writeText(text).then(() => {
    if (url) window.open(url)
    else {
      $('#copy-success').removeClass('d-none')
      setTimeout(() => $('#copy-success').addClass('d-none'), 3000)
    }
  }, () => {
    alert('Não foi possível copiar, copie manualmente!')
    if (url) window.open(url)
  })

}

function topo(){
  $('html, body').animate({ scrollTop: 0 }, 800)
}

function submit() {
  let csrf = getCSRF()
  $('#checkbox').append(csrf)
  $('#checkbox').trigger('submit')
}

function getCSRF(){
  let input = document.createElement('input')
  input.setAttribute('type', 'hidden')
  input.id = 'token'
  input.setAttribute('name', '_token')
  input.value = CSRF
  return input
}

function getReCaptcha(token) {
  let input = document.createElement('input')
  input.setAttribute('type', 'hidden')
  input.id = 'g-recaptcha-response'
  input.setAttribute('name', 'g-recaptcha-response')
  input.value = token
  return input
}

function createCookie(name, value, days) {
  let expires
  if (days) {
    let date = new Date()
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
    expires = '; expires=' + date.toGMTString()
  } else {
    expires = ''
  }
  document.cookie = `${name}=${value}${expires}; path=/`
}

function deleteCookie(cookie_name) {
  createCookie(cookie_name, '', -1)
}

function getPrefer(endpoint) {
  $.ajax({
    url: '/prefer/get',
    data: JSON.stringify({ 'endpoint': endpoint, '_token': CSRF }),
    dataType: 'json',
    contentType: 'application/json',
    type: 'POST'
  }).done((data) => {
    if (data.success) {
      let checked = 0
      for (let i = 0; i < data.pref.length; i++) {
        if (data.pref[i]) {
          $('#p' + (i + 1)).attr('checked', true)
          checked++
        }
      }
      if (checked == data.pref.length) {
        $('#all').attr('checked', true)
      }
      $('#preferencias').removeClass('d-none')
    } else {
      if (typeof data.message != undefined) {
        alert(data.message)
      } else {
        alert('Falha')
      }
    }
  }).fail(() => {
    alert('Falha')
  })
}

function redirectUrl() {
  let url = $('#url').val()
  url = url.strstr('?')
  window.open(`/redirect?url=${url}`)
  $('#url').val('')
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

function sendForm(id, token){
  let valores = new Object()
  for (let valor of $(`#${id}`).serializeArray()) {
    valores[valor.name] = valor.value
  }
  valores['_token'] = CSRF
  valores['g-recaptcha-response'] = token
  let value = $(`#${id}-submit`).html()
  let btn = $(`#${id}-submit`)
  let errorId = `#error-${id}`
  btn.attr('disabled', true)
  btn.html('Aguarde ...')
  $(`#${id}`).removeClass('was-validated')
  $(errorId).addClass('d-none')
  $.ajax({
    url: $(`#${id}`).attr('action'),
      data: JSON.stringify(valores),
      dataType: 'json',
      contentType: 'application/json',
      type: 'POST'
    }).done(function (data) {
    if (typeof data.success === undefined) {
      $(errorId).html('<p class="alert alert-danger">Erro desconhecido :(</p>')
      $(errorId).removeClass('d-none')
    } else if (typeof data.message !== undefined){
      if (!data.success) {
        $(errorId).html('<p class="alert alert-danger">' + data.message + '</p>')
        $(errorId).removeClass('d-none')
      } else {
        $(errorId).html('<div class="alert alert-success">' + data.message + '</div>')
        $(errorId).removeClass('d-none')
      }
    }
  })
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
  grecaptcha.ready(() => {
    grecaptcha.execute(KEY_V3_RECAPTCHA, { action: action })
    .then((token) => {
      if (type === 'ajax') {
        sendForm(id, token)
      } else if (type === 'search') {
        let q = $('#q').val()
        pesquisar(q, token)
      } else if (type === 'paginate') {
        paginateSearch(id, token)
      }
    })
  })
}

$(function () {
  'use-stric'
  $('.ajax-form').on('submit', function (e) {
    if (!this.checkValidity()) {
      e.preventDefault()
      e.stopPropagation()
    } else {
      e.preventDefault()
      getToken($(this).attr('data-action'), this.id)
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
      if (this.id == 'deeplink') {
        redirectUrl()
      }
      $(this).removeClass('was-validated')
    }
  })

  if (navigator.share) {
    $('.plus-share').removeClass('d-none')
  }

  $('.igs').on('click', function () {
    alert('Tire print e compartilhe nas suas storys, para fechar dê um duplo clique!')
    igShare('#' + $(this).closest('.promo').attr('id'))
  })

  $('.mre').on('click', function () {
    let text, element, url
    if (($(this).closest('.promo').attr('id') !== undefined)) {
      element = '#' + $(this).closest('.promo').attr('id')
      text = getText(element) + '\n'
      url = getUrl(element)
    } else {
      element = '#' + $(this).closest('.cupom').attr('id')
      text = getTextCupom(element) + '\n'
      url = getUrlCupom(element)
    }

    navigator.share({
      text: text,
      url: url,
    })
  })

  $('.cpy').on('click', function() {
    let text, element, url
    if (($(this).closest('.promo').attr('id') !== undefined)) {
      element = '#' + $(this).closest('.promo').attr('id')
      text = getText(element)
      url = getUrl(element)
    } else {
      element = '#' + $(this).closest('.cupom').attr('id')
      text = getTextCupom(element)
      url = getUrlCupom(element)
    }

    text += `\n\n${url}`

    copyText(text)
  })

  $('.wpp').on('click', function () {
    let text, element, url
    if (($(this).closest('.promo').attr('id') !== undefined)) {
      element = '#' + $(this).closest('.promo').attr('id')
      text = getText(element)
      url = getUrl(element)
    } else {
      element = '#' + $(this).closest('.cupom').attr('id')
      text = getTextCupom(element)
      url = getUrlCupom(element)
    }

    text += `\n\n${url}`

    window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text))
  })

  $('.tlg').on('click', function () {
    let text, element, url
    if (($(this).closest('.promo').attr('id') !== undefined)) {
      element = '#' + $(this).closest('.promo').attr('id')
      text = '\n' + getText(element)
      url = getUrl(element)
    } else {
      element = '#' + $(this).closest('.cupom').attr('id')
      text = '\n' + getTextCupom(element)
      url = getUrlCupom(element)
    }

    window.open('https://telegram.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text))
  })

  $('.twt').on('click', function () {
    let text, element, url
    if (($(this).closest('.promo').attr('id') !== undefined)) {
      element = '#' + $(this).closest('.promo').attr('id')
      text = getText(element) + '\n\n'
      url = getUrl(element)
    } else {
      element = '#' + $(this).closest('.cupom').attr('id')
      text = getTextCupom(element) + '\n\n'
      url = getUrlCupom(element)
    }
    window.open('https://twitter.com/share?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text))
  })

  $('#ig-share').on('dbclick', function () {
    $(this).addClass('d-none')
  })

  $('.copy-redirect').on('click', function (){
    let element = $(this).closest('.promo').attr('id')
    element = (element === undefined) ? '#' + $(this).closest('.cupom').attr('id') : '#' + element
    let url = $(this).attr('data-link')
    let code = $(element).find('.code-text').val()
    copyText(code, url)
  })

  $(window).on('scroll', function () {
    let nav = $('#cabecalho')
    if ($(this).scrollTop() > 90) {
      nav.addClass('fixed-top')
      nav.addClass('shadow')
      $('body').css('padding-top', 90)
    } else {
      nav.removeClass('fixed-top')
      nav.removeClass('shadow')
      $('body').css('padding-top', 0)
    }
  })

  $('#inotify').on('click', function () {
    $('#notify').addClass('d-none')
    createCookie('no_notify', 1, 60)
  })

  if (window.location.pathname.indexOf('/search') == 0) {
    $('.page-link').on('click', function (e) {
      e.preventDefault()
      let href = $(this).attr('href')
      getToken('paginate', href, 'paginate')
    })

    $('.filtros').on('click', function (e) {
      e.preventDefault()
      let href = $(this).attr('href')
      getToken('paginate', href, 'paginate')
    })
  }

  $("#prefers input[type='checkbox']").on('change', function () {
    if ($("#prefers input[type='checkbox']").is(':checked')) {
      $('#para').attr('disabled', true)
      $('#para').removeAttr('required')
    } else {
      $('#para').attr('disabled', false)
      $('#para').attr('required')
    }
  })

  $('#all').on('change', function () {
    $('.prefer').prop('checked', $(this).is(':checked'))
  })

  $('#notificacao').on('change', function () {
    if ($(this).is(':checked')){
      $('#prefers').removeClass('d-none')
      $('#prefers').addClass('d-md-flex')
    } else{
      $('#prefers').addClass('d-none')
      $('#prefers').removeClass('d-md-flex')
      $('.prefer').prop('checked', false)
    }
  })

  $('.prefer').on('change', function () {
    let all = true
    for(check of $('.prefer')){
      if (!$(check).is(':checked')){
        all = false
      }
    }

    $('#all').prop('checked', all)
  })

  $('#btn-topo').on('click', topo)
})