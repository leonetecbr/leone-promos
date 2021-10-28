const KeyV3Recaptcha = '6LdiepQaAAAAAAzLXLD1le5GHf0JRShTQvNX2LHt'

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
  $('#share-link').html($(element).attr('data-short-link'))
  $('#ig-share').fadeIn('slow')
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

function accept() {
  createCookie('accept', 'true', 365)
  $('.aviso_eu_cookie').fadeOut('slow')
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

function validate_search() {
  if ($('#qs').val().length < 3 || $('#qs').val().length > 64) {
    $('#qs').css({ 'border': '1px solid #F00' })
    $('.iqs').fadeIn('slow')
  } else {
    $('#form').append('<input type="hidden" name="_token" id="token" value="' + csrf + '">')

    grecaptcha.ready(function () {
      grecaptcha.execute(KeyV3Recaptcha, { action: 'search' }).then(function (token) {
        $('#form').append('<input type="hidden" name="g-recaptcha-response" value="' + token + '">')
        var valores = new Object()
        for (var valor of $('#form').serializeArray()) {
          valores[valor.name] = valor.value
        }
        $('#form').attr('action', '/search/' + valores.q)
        $('#form').submit()
      })
    })
  }
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
    expires = ' expires=' + date.toGMTString()
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
      $('#preferencias').removeClass('hidden')
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

function getUrl(element) {
  return window.location.href //$(element).attr('data-short-link')
}

$(document).ready(function () {
  if (navigator.share) {
    $('.plus-share').fadeIn('slow')
  }

  $('.igs').click(function () {
    alert('Tire print e compartilhe nas suas storys, para fechar dê um duplo clique!')
    ig_share('#' + $(this).closest('.promo').attr('id'))
  })

  $('.mre').click(function () {
    const element = '#' + $(this).closest('.promo').attr('id')
    const url = getUrl(element)
    const text = getText(element)

    navigator.share({
      text: text,
      url: url,
    })
  })

  $('.cpy').click(function () {
    const element = '#' + $(this).closest('.promo').attr('id')
    var text = getText(element)
    const url = getUrl(element)

    text += "\n\n" + url

    copy_s(text)
  })

  $('.wpp').click(function () {
    const element = '#' + $(this).closest('.promo').attr('id')
    var text = getText(element)
    const url = getUrl(element)

    text += "\n\n" + url

    window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text))
  })

  $('.tlg').click(function () {
    const element = '#' + $(this).closest('.promo').attr('id')
    var text = '\n' + getText(element)
    const url = getUrl(element)

    window.open('https://telegram.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text))
  })

  $('.twt').click(function () {
    const element = '#' + $(this).closest('.promo').attr('id')
    var text = getText(element) + '\n\n'
    const url = getUrl(element)

    window.open('https://twitter.com/share?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text))
  })

  $('#ig-share').dblclick(function () {
    $(this).fadeOut('slow')
  })

  var nav = $('#cabecalho')
  $(window).scroll(function () {
    if ($(this).scrollTop() > 90) {
      nav.addClass('menu-fixo')
      $('body').css('padding-top', 90)
    } else {
      nav.removeClass('menu-fixo')
      $('body').css('padding-top', 0)
    }
  })

  $('#deeplink').submit(function (e) {
    e.preventDefault()
    var url_validate = /(https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    if (!url_validate.test($('#url').val())) {
      $('#url').css({ 'border': '1px solid #F00' })
      $('.iurl').fadeIn('slow')
    } else {
      var url = $('#url').val()
      url = url.strstr('?')
      window.open('/redirect?url=' + url)
      $('#url').val('')
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
      $('#form').fadeIn('slow')
      $('#btn-search').html('<i class="fas fa-times"></i>')
      $('html, body').animate({ scrollTop: '80px' }, 800)
      search = true
    } else {
      $('#form').fadeOut('slow')
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
    $('#notify').fadeOut('slow')
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