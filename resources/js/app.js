String.prototype.strstr = function (search) {
  var position = this.indexOf(search)
  if (position == -1) {
    return this
  }
  return this.substr(0, position)
}

function ig_share(element) {
  const title = $(element).find('.product-title').html()
  const desc = $(element).find('.description').html()
  const price_from = $(element).find('del').html()
  const code = $(element).find('.discount').val()
  $('#product-title').html(title)
  $('#product-image').attr('src', $(element).find('.product-image').attr('src'))
  $('#product-image').attr('alt', title)
  if (price_from !== undefined) {
    $('#product-price-from').html(price_from)
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
  $('#product-price-to').html($(element).find('h4').html())
  $('#share-link').html(getUrl(element))
  $('#ig-share').fadeIn('slow')
}

function getText(element) {
  const desc = $(element).find('.description').html()
  var text = $(element).find('h4').html()
  const price_from = $(element).find('del').html()
  const title = $(element).find('.product-title').html()

  if (text !== 'Grátis') {
    text = 'Por apenas: ' + text
  }

  if (price_from !== undefined) {
    text = 'De: ' + price_from + '\n\n' + text
  }

  text = title + '.\n\n' + text + '!'

  if (desc !== undefined) {
    text += '\n\n' + desc
  }

  return text
}

function getTextCupom(element) {
  var text = $(element).find('h4').html() + ' no(a) ' + $(element).find('img').attr('alt')
  const vigency = $(element).find('.cupom-vigency').html()
  var cupom = $(element).find('.cupom-code').val()
  var code = cupom.substr(0, cupom.length - 2)

  cupom = 'Cupom: ' + code.replace(/\w/g, '*') + cupom.substr(-2)

  text += '\n\n' + vigency + '\n\n' + cupom

  return text
}

function getText(element) {
  const desc = $(element).find('.description').html()
  var text = $(element).find('h4').html()
  const price_from = $(element).find('del').html()
  const title = $(element).find('.product-title').html()

  if (text !== 'Grátis') {
    text = 'Por apenas: ' + text;
  }

  text = title + '.\n\n' + text + '!'

  if (desc !== undefined) {
    text += '\n\n' + desc
  }

  return text
}

function getUrl(element) {
  return 'https://para.promo/o/' + element.replace('#', '')
}

function getUrlCupom(element) {
  return 'https://para.promo/c/' + element.replace('#cupom_', '')
}

function accept() {
  createCookie('accept', 'true', 365)
  $('#aviso_cookie').fadeOut('slow')
}

function copy_s(t) {
  if (!navigator.clipboard) {
    $('#noeye').html('<textarea id="text_copy">' + t + '</textarea>')
    $('#text_copy').select()
    document.execCommand('copy')
    $('#noeye').html('')
  } else {
    navigator.clipboard.writeText(t)
  }
  $('#copy_sucess').fadeIn('slow')
  setTimeout(function () { $('#copy_sucess').fadeOut('slow') }, 3000)
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
  $('#checkbox').append('<input type="hidden" name="_token" id="token" value="' + csrf + '">')
  $('#checkbox').submit()
}

function createCookie(name, value, days) {
  var expires
  if (days) {
    var date = new Date()
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
    expires = '; expires=' + date.toGMTString()
  } else {
    expires = ''
  }
  document.cookie = name + '=' + value + expires + ' path=/'
}

function getPrefer(endpoint) {
  $.ajax({
    url: '/prefer/get',
    data: JSON.stringify({ 'endpoint': endpoint, '_token': csrf }),
    dataType: 'json',
    contentType: 'application/json',
    type: 'POST'
  }).done(function (data) {
    if (data.success) {
      var checked = 0
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
  }).fail(function () {
    alert('Falha')
  })
}

function redirectUrl() {
  var url = $('#url').val()
  url = url.strstr('?')
  window.open('/redirect?url=' + url)
  $('#url').val('')
}

function pesquisar(q, token) {
  alert(q)
  alert(token)
}

$(document).ready(function () {
  'use-stric';
  $('.ajax-form').submit(function (e) {
    if (!this.checkValidity()) {
      e.preventDefault()
      e.stopPropagation()
    } else {
      e.preventDefault();
      getToken('form-' + this.id, this);
    }
    this.classList.add('was-validated')
  });

  function getToken(action, dados, type = 'ajax') {
    grecaptcha.ready(function () {
      grecaptcha.execute(KeyV3Recaptcha, { action: action }).then(function (token) {
        if (type == 'ajax') {
          sendForm(dados, token);
        } else {
          if (type == 'search') {
            pesquisar(dados, token);
          }
        }
      });
    });
  }

  $('.needs-validation').submit(function (event) {
    if (this.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
      $(this).addClass('was-validated');
    } else {
      event.preventDefault();
      $(this).addClass('was-validated');
      if (this.id == 'deeplink') {
        redirectUrl()
      } else if (this.id == 'search' || this.id == 'search-lg') {
        var q = (this.id == 'search') ? $('#qs').val() : $('#ql').val();
        getToken('search', q, 'search')
      }
      $(this).removeClass('was-validated');
    }
  });

  if (navigator.share) {
    $('.plus-share').fadeIn('slow')
  }

  $('.igs').click(function () {
    alert('Tire print e compartilhe nas suas storys, para fechar dê um duplo clique!')
    ig_share('#' + $(this).closest('.promo').attr('id'))
  })

  $('.mre').click(function () {
    var text, element, url
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

  $('.cpy').click(function () {
    var text, element, url
    if (($(this).closest('.promo').attr('id') !== undefined)) {
      element = '#' + $(this).closest('.promo').attr('id')
      text = getText(element)
      url = getUrl(element)
    } else {
      element = '#' + $(this).closest('.cupom').attr('id')
      text = getTextCupom(element)
      url = getUrlCupom(element)
    }

    text += "\n\n" + url

    copy_s(text)
  })

  $('.wpp').click(function () {
    var text, element, url
    if (($(this).closest('.promo').attr('id') !== undefined)) {
      element = '#' + $(this).closest('.promo').attr('id')
      text = getText(element)
      url = getUrl(element)
    } else {
      element = '#' + $(this).closest('.cupom').attr('id')
      text = getTextCupom(element)
      url = getUrlCupom(element)
    }

    text += "\n\n" + url

    window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text))
  })

  $('.tlg').click(function () {
    var text, element, url
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

  $('.twt').click(function () {
    var text, element, url
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

  $('#ig-share').dblclick(function () {
    $(this).fadeOut('slow')
  })

  var nav = $('#cabecalho')
  $(window).scroll(function () {
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

  $('.ajax_form').submit(function (e) {
    e.preventDefault()
    form = this
    grecaptcha.ready(function () {
      grecaptcha.execute(KeyV3Recaptcha, { action: 'send_form' }).then(function (token) {
        var valores = new Object()
        for (var valor of $(form).serializeArray()) {
          valores[valor.name] = valor.value
        }
        valores['_token'] = csrf
        valores['g-recaptcha-response'] = token
        let id = form.id
        let value = $('#' + id + '_submit').html()
        let btn = $('#' + id + '_submit')
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
            $('#error_' + id).html('<p class="erro mt-1">Erro desconhecido :(</p>')
            $('#error_' + id).show('slow')
          } else if (!data.success) {
            $('#error_' + id).html('<p class="erro mt-1">' + data.message + '</p>')
            $('#error_' + id).show('slow')
          } else {
            $('#error_' + id).html('<p class="bolder">' + data.message + '</p>')
            $('#error_' + id).show('slow')
          }
        }).fail(function () {
          $('#error_' + id).html('<p class="erro mt-1">Não foi possível enviar os dados, tente novamente!</p>')
          $('#error_' + id).show('slow')
        }).always(function () {
          btn.html(value)
          btn.attr('disabled', false)
        })
      })
    })
  })

  var search = false
  $('#btn-menu').click(function () {
    $('#menu').fadeIn('slow')
  })

  $('#btn-search').click(function () {
    if (search === false) {
      $('#search').removeClass('d-none')
      $('#btn-search').html('<i class="fas fa-times"></i>')
      $('html, body').animate({ scrollTop: '80px' }, 800)
      search = true
    } else {
      $('#search').addClass('d-none')
      $('#btn-search').html('<i class="fas fa-search"></i>')
      search = false
    }
  })

  $('#close').click(function () {
    $('#menu').fadeOut('slow')
  })

  $('input').change(function () {
    $(this).css({ 'border': '1px solid #fff' })
    var id = $(this).attr('id')
    $('.i' + id).fadeOut('slow')
  })

  $('select').change(function () {
    $(this).css({ 'border': '1px solid #fff' })
    var id = $(this).attr('id')
    $('.i' + id).fadeOut('slow')
  })

  $('textarea').change(function () {
    $(this).css({ 'border': '1px solid #fff' })
    var id = $(this).attr('id')
    $('.i' + id).fadeOut('slow')
  })

  $('#inotify').click(function () {
    $('#notify').addClass('d-none')
    createCookie('no_notify', 1, 60)
  })

  $('.pages').click(function () {
    e.preventDefault()
    var href = $(this).attr('href')
    grecaptcha.ready(function () {
      grecaptcha.execute(KeyV3Recaptcha, { action: 'pagination' }).then(function (token) {
        $('body').append('<form method="post" id="reload" action="' + href + '"><input type="hidden" name="g-recaptcha-response" value="' + token + '"/><input type="hidden" name="_token" id="token" value="' + csrf + '"></form>')
        $('#reload').submit()
      })
    })
  })
})

$('.prefer').change(function () {
  if ($(this).is(':checked')) {
    $('#para').attr('disabled', true)
    $('#para').removeAttr('required')
  } else {
    $('#para').attr('disabled', false)
    $('#para').attr('required')
  }
})

$('#all').change(function () {
  if ($(this).is(':checked')) {
    $('.prefer').attr('checked', true)
  } else {
    $('.prefer').removeAttr('checked')
  }
})