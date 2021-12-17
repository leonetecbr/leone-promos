let isSubscribed = false
let swRegistration = null
let btn = $('#btn-notify')
let sub

function urlB64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4)
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/')

  const rawData = window.atob(base64)
  const outputArray = new Uint8Array(rawData.length)

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i)
  }
  return outputArray
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
  navigator.serviceWorker.register('/sw.js').then(function (swReg) {
    swRegistration = swReg
    initializeUI()
  })
} else {
  btn.html('Notificações não suportadas')
  $('#notify-unsupport').removeClass('d-none')
}

function initializeUI() {
  if (document.cookie.indexOf('no_notify') < 0) {
    $('#notify').removeClass('d-none')
  }
  btn.attr('disabled', false)
  btn.click(function () {
    btn.attr('disabled', true)
    btn.html('Aguarde ...')
    if (isSubscribed) {
      unsubscribeUser()
    } else {
      subscribeUser()
    }
  })
  swRegistration.pushManager.getSubscription().then(function (subscription) {
    sub = subscription
    isSubscribed = !(subscription === null)
    if (isSubscribed) {
      if (window.location.pathname == '/notificacoes') {
        getPrefer(subscription.endpoint)
        $('#endpoint').val(subscription.endpoint)
      }
    }
    updateBtn()
  })
}

function updateBtn() {
  if (Notification.permission === 'denied') {
    $('#btn-notify').html('Notificações bloqueadas')
    $('#btn-notify').attr("disabled", true)
    $('#notify-bloqued').removeClass('d-none')
    if (sub) {
      update('remove')
    }
    return
  }

  btn.attr('disabled', false)
  if (isSubscribed) {
    setTimeout(function () {
      createCookie('no_notify', 1, 60)
      $('#notify').hide('slow') }
    , 1000)
    btn.html('Desativar notificações')
  } else {
    btn.html('Ativar notificações')
  }
}

function subscribeUser() {
  const applicationServerKey = urlB64ToUint8Array(KEY_VAPID_PUBLIC)
  swRegistration.pushManager.subscribe({
    userVisibleOnly: true,
    applicationServerKey: applicationServerKey
  }).then(function (subscription) {
    sub = subscription
    update('add')
  })
    .catch(function () {
      updateBtn()
    })
}

function unsubscribeUser() {
  if (sub) {
    sub.unsubscribe()
    update('remove')
    $('#preferencias').addClass('d-none')
  } else {
    updateBtn()
  }
}

function update(action) {
  grecaptcha.ready(function () {
    grecaptcha.execute(KEY_V3_RECAPTCHA, { action: 'notify' }).then(function (token) {
      const data = {
        subscription: sub,
        action: action,
        token: token,
        _token: CSRF
      }
      $.ajax({
        url: '/register',
        type: 'POST',
        data: JSON.stringify(data),
        dataType: 'json',
        contentType: 'application/json',
        success: function (data) {
          processResponse(data, action)
        }
      }).fail(function () {
        $('#notify').append('<p class="erro mt-2 center">Erro desconhecido!</p>')
        if (sub) {
          sub.unsubscribe()
        }
        return updateBtn()
      })
    })
  })
}

function processResponse(data, action) {
  if (typeof data.success == 'undefined') {
    $('#notify').append('<p class="erro mt-2 center">Erro desconhecido!</p>')
    if (sub) {
      sub.unsubscribe()
    }
  } else if (data.success && action == 'add') {
    isSubscribed = true
  } else if (data.success && action == 'remove') {
    isSubscribed = false
  } else if (typeof data.erro !== 'undefined') {
    $('#notify').append('<p class="erro mt-2 center">' + data.erro + '</p>')
    if (sub) {
      sub.unsubscribe()
    }
  } else {
    $('#notify').append('<p class="erro mt-2 center">Erro desconhecido!</p>')
    if (sub) {
      sub.unsubscribe()
    }
  }
  return updateBtn()
}