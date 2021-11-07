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
  $('#product-price-to').html($(element).find('.pricing-card-title').html())
  $('#share-link').html(getUrl(element))
  $('#ig-share').removeClass('d-none')
}

function getText(element) {
  const desc = $(element).find('.description').html()
  var text = $(element).find('.pricing-card-title').html()
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
  var text = $(element).find('.card-title').html() + ' no(a) ' + $(element).find('.loja-image').attr('alt')
  const vigency = $(element).find('.cupom-vigency').html()
  var cupom = $(element).find('.discount').val()
  var code = cupom.substr(0, cupom.length - 2)

  cupom = 'Cupom: ' + code.replace(/\w/g, '*') + cupom.substr(-2)

  text += '\n\n' + vigency + '\n\n' + cupom

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
  $('#copy_sucess').removeClass('d-none')
  setTimeout(function () { $('#copy_sucess').addClass('d-none') }, 3000)
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
  $('body').append('<form method="post" action="/search/' + q + '" id="pesquisar"><input type="hidden" name="_token" value="' + csrf + '"/><input type="hidden" name="g-recaptcha-response" value="' + token + '"/></form>')
  $('#pesquisar').submit();
}

function paginateSearch(href, token) {
  $('body').append('<form method="post" action="' + href + '" id="pesquisar"><input type="hidden" name="_token" value="' + csrf + '"/><input type="hidden" name="g-recaptcha-response" value="' + token + '"/></form>')
  $('#pesquisar').submit();
}

function getToken(action, dados, type = 'ajax') {
  grecaptcha.ready(function () {
    grecaptcha.execute(KeyV3Recaptcha, { action: action }).then(function (token) {
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
    $('.plus-share').removeClass('d-none')
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
    $(this).addClass('d-none')
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

  if (window.location.pathname.indexOf("/search") == 0) {
    $('.page-link').click(function (e) {
      e.preventDefault()
      var href = $(this).attr('href')
      getToken('paginate', href, 'paginate')
    })
  }

  $("#prefers input[type='checkbox']").change(function () {
    if ($("#prefers input[type='checkbox']").is(':checked')) {
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
})
/*
*
*  Push Notifications codelab
*  Copyright 2015 Google Inc. All rights reserved.
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      https://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License
*
* Modifications were made to make the code fit my project 
*/

let isSubscribed = false;
let swRegistration = null;
let btn = $('#btn-notify');
let sub;

function urlB64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
  navigator.serviceWorker.register('/sw.js').then(function (swReg) {
    swRegistration = swReg;
    initializeUI();
  });
} else {
  btn.html('Notificações não suportadas');
}

function initializeUI() {
  if (document.cookie.indexOf("no_notify") < 0) {
    $('#notify').removeClass('d-none');
  }
  btn.attr('disabled', false);
  btn.click(function () {
    btn.attr('disabled', true);
    btn.html('Aguarde ...');
    if (isSubscribed) {
      unsubscribeUser();
    } else {
      subscribeUser();
    }
  });
  swRegistration.pushManager.getSubscription().then(function (subscription) {
    sub = subscription;
    isSubscribed = !(subscription === null);
    if (isSubscribed) {
      if (window.location.pathname == '/notificacoes') {
        getPrefer(subscription.endpoint);
        $('#endpoint').val(subscription.endpoint);
      }
    }
    updateBtn();
  });
}

function updateBtn() {
  if (Notification.permission === 'denied') {
    $('.js-push-btn').html('Notificações bloqueadas');
    $('.js-push-btn').attr("disabled", true);
    if (sub) {
      update('remove');
    }
    return;
  }

  btn.attr('disabled', false);
  if (isSubscribed) {
    setTimeout(function () { createCookie('no_notify', 1, 60); $('#notify').hide('slow'); }, 1000);
    btn.html('Desativar notificações');
  } else {
    btn.html('Ativar notificações');
  }
}

function subscribeUser() {
  const applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
  swRegistration.pushManager.subscribe({
    userVisibleOnly: true,
    applicationServerKey: applicationServerKey
  }).then(function (subscription) {
    sub = subscription;
    update('add');
  })
    .catch(function () {
      updateBtn();
    });
}

function unsubscribeUser() {
  if (sub) {
    sub.unsubscribe();
    update('remove');
    $('#preferencias').addClass('d-none');
  } else {
    updateBtn();
  }
}

function update(action) {
  grecaptcha.ready(function () {
    grecaptcha.execute('6LdiepQaAAAAAAzLXLD1le5GHf0JRShTQvNX2LHt', { action: 'notify' }).then(function (token) {
      const data = {
        subscription: sub,
        action: action,
        token: token,
        _token: csrf
      }
      document.cookie = "humans_21909=1";
      $.ajax({
        url: "/register",
        type: "POST",
        data: JSON.stringify(data),
        dataType: "json",
        contentType: 'application/json',
        success: function (data) {
          processResponse(data, action);
        }
      }).fail(function () {
        $('#notify').append('<p class="erro mt-2 center">Erro desconhecido!</p>');
        if (sub) {
          sub.unsubscribe();
        }
        return updateBtn();
      });
    });
  });
}

function processResponse(data, action) {
  if (typeof data.success == 'undefined') {
    $('#notify').append('<p class="erro mt-2 center">Erro desconhecido!</p>');
    if (sub) {
      sub.unsubscribe();
    }
  } else if (data.success && action == 'add') {
    isSubscribed = true;
  } else if (data.success && action == 'remove') {
    isSubscribed = false;
  } else if (typeof data.erro !== 'undefined') {
    $('#notify').append('<p class="erro mt-2 center">' + data.erro + '</p>');
    if (sub) {
      sub.unsubscribe();
    }
  } else {
    $('#notify').append('<p class="erro mt-2 center">Erro desconhecido!</p>');
    if (sub) {
      sub.unsubscribe();
    }
  }
  return updateBtn();
}