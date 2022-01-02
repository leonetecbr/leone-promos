String.prototype.strstr = function (search) {
  let position = this.indexOf(search)
  if (position == -1) {
    return this
  }
  return this.substring(0, position)
}

function igShare(element) {
  const title = $(element).find('.product-title').html()
  const desc = $(element).find('.description').html()
  const priceFrom = $(element).find('del').html()
  const code = $(element).find('.discount').val()
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
  const desc = $(element).find('.description').html()
  let text = $(element).find('.pricing-card-title').html()
  const priceFrom = $(element).find('del').html()
  const title = $(element).find('.product-title').html()

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
  const vigency = $(element).find('.cupom-vigency').html()
  let cupom = String($(element).find('.discount').val())
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

function copyS(t) {
  if (!navigator.clipboard) {
    let textArea = document.createElement('textarea')
    t = document.createTextNode(t)
    textArea.id = 'text-copy'
    textArea.appendChild(t)
    $('#noeye').html(textArea)
    $('#text-copy').select()
    document.execCommand('copy')
    $('#noeye').html('')
  } else {
    navigator.clipboard.writeText(t)
  }
  $('#copy-success').removeClass('d-none')
  setTimeout(() => $('#copy-success').addClass('d-none'), 3000)
}

function copy(e, o) {
  if (!navigator.clipboard) {
    $(o).attr('disabled', false)
    $(o).select()
    document.execCommand('copy')
    $(o).attr('disabled', true)
  } else {
    const text = $(o).val()
    navigator.clipboard.writeText(text)
  }

  window.open(e)
}

function submit(token) {
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

function getToken(action, dados, type = 'ajax') {
  grecaptcha.ready(() => {
    grecaptcha.execute(KEY_V3_RECAPTCHA, { action: action })
    .then((token) => {
      if (type == 'ajax') {
        sendForm(dados, token);
      } else {
        if (type == 'search') {
          pesquisar(dados, token);
        } else if (type == 'paginate') {
          paginateSearch(dados, token)
        }
      }
    });
  });
}

$(function () {
  'use-stric';
  $('.ajax-form').on('submit', function (e) {
    if (!this.checkValidity()) {
      e.preventDefault()
      e.stopPropagation()
    } else {
      e.preventDefault();
      getToken('form-' + this.id, this);
    }
    this.classList.add('was-validated')
  });

  $('.needs-validation').on('submit', function (event) {
    if (this.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
      $(this).addClass('was-validated');
    } else {
      event.preventDefault();
      $(this).addClass('was-validated');
      if (this.id == 'deeplink') {
        redirectUrl()
      } else if (this.id == 'search') {
        let q = $('#q').val();
        getToken('search', q, 'search')
      }
      $(this).removeClass('was-validated');
    }
  });

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

    copyS(text)
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

  $('.ajax-form').on('submit', function (e) {
    e.preventDefault()
    form = this
    grecaptcha.ready(() => {
      grecaptcha.execute(KEY_V3_RECAPTCHA, { action: 'send_form' })
      .then((token) => {
        let valores = new Object()
        for (let valor of $(form).serializeArray()) {
          valores[valor.name] = valor.value
        }
        valores['_token'] = CSRF
        valores['g-recaptcha-response'] = token
        let id = form.id
        let value = $(`#${id}-submit`).html()
        let btn = $(`#${id}-submit`)
        let errorId = `#error-${id}`
        btn.attr('disabled', true)
        btn.html('Aguarde ...')
        $.ajax({
          url: form.action,
          data: JSON.stringify(valores),
          dataType: 'json',
          contentType: 'application/json',
          type: 'POST'
        }).done(function (data) {
          if (typeof data.success == 'undefined' || typeof data.message == 'undefined') {
            $(errorId).html('<p class="erro mt-1">Erro desconhecido :(</p>')
            $(errorId).show('slow')
          } else if (!data.success) {
            $(errorId).html('<p class="erro mt-1">' + data.message + '</p>')
            $(errorId).show('slow')
          } else {
            $(errorId).html('<p class="bolder">' + data.message + '</p>')
            $(errorId).show('slow')
          }
        })
        .fail(() => {
          $(errorId).html('<p class="erro mt-1">Não foi possível enviar os dados, tente novamente!</p>')
          $(errorId).show('slow')
        })
        .always(() => {
          btn.html(value)
          btn.attr('disabled', false)
        })
      })
    })
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
    if ($(this).is(':checked')) {
      $('.prefer').attr('checked', true)
    } else {
      $('.prefer').removeAttr('checked')
    }
  })
})