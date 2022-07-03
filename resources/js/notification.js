let isSubscribed = false, swRegistration = null, sub
const btn = $('#btn-notification')

function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4)
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/')

    const rawData = window.atob(base64)
    const outputArray = new Uint8Array(rawData.length)

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i)
    }
    return outputArray
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/sw.js').then((swReg) => {
        swRegistration = swReg
        initializeUI()
    })
} else {
    btn.html('Notificações não suportadas')
    $('#notification-unsupported').removeClass('d-none')
}

function initializeUI() {
    if (document.cookie.indexOf('no-notification') < 0) {
        $('#notification').removeClass('d-none')
    }

    btn.attr('disabled', false)
    btn.on('click', () => {
        btn.attr('disabled', true)
        btn.html('Aguarde ...')
        if (isSubscribed) {
            unsubscribeUser()
        } else {
            subscribeUser()
        }
    })

    swRegistration.pushManager.getSubscription()
        .then((subscription) => {
            sub = subscription
            isSubscribed = !(subscription === null)
            if (isSubscribed) {
                if (window.location.pathname === '/notificacoes') {
                    getPrefer(subscription.endpoint)
                    $('#endpoint').val(subscription.endpoint)
                } else if (window.location.pathname === '/' && document.cookie.indexOf('no_update') < 0) {
                    update('update')
                }
            } else if (Notification.permission === 'granted' && document.cookie.indexOf('no_resubscribe') < 0) {
                const applicationServerKey = urlB64ToUint8Array(KEY_VAPID_PUBLIC)
                swRegistration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: applicationServerKey
                })
                    .then((subscription) => {
                        sub = subscription
                        update('update')
                    })
                    .catch(() => console.log('Falha na reativação das notificações'))
            }
            updateBtn()
        })
}

function updateBtn() {
    if (Notification.permission === 'denied') {
        btn.html('Notificações bloqueadas')
        btn.attr("disabled", true)
        $('#notification-blocked').removeClass('d-none')
        if (sub) {
            update('remove')
        }
        return
    }

    btn.attr('disabled', false)
    if (isSubscribed) {
        setTimeout(() => {
            createCookie('no-notification', 1, 60)
            $('#notification').hide('slow')
        }, 1000)
        btn.html('Desativar notificações')
    } else {
        btn.html('Ativar notificações')
    }
}

function subscribeUser() {
    deleteCookie('no_resubscribe')
    const applicationServerKey = urlB64ToUint8Array(KEY_VAPID_PUBLIC)
    swRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: applicationServerKey
    })
        .then((subscription) => {
            sub = subscription
            update('add')
        })
        .catch(() => updateBtn())
}

function unsubscribeUser() {
    createCookie('no_resubscribe', 1, 365)
    if (sub) {
        sub.unsubscribe()
        isSubscribed = false
        update('remove')
        $('#preferencias').addClass('d-none')
    } else {
        updateBtn()
    }
}

function update(action) {
    let interval = setInterval(function () {
        if (window.grecaptcha) {
            clearInterval(interval)
            grecaptcha.ready(() => {
                grecaptcha.execute(KEY_V3_RECAPTCHA, {action: 'change_notification'})
                    .then((token) => {
                        const data = {
                            subscription: sub,
                            action: action,
                            token: token,
                            _token: CSRF
                        }

                        $.ajax({
                            url: '/notificacoes/manage',
                            type: 'POST',
                            data: JSON.stringify(data),
                            dataType: 'json',
                            contentType: 'application/json',
                            success: (data) => {
                                processResponse(data, action)
                            }
                        })
                            .fail(() => {
                                $('#notify').append('<p class="erro mt-2 center">Erro desconhecido!</p>')
                                if (sub) {
                                    sub.unsubscribe()
                                    isSubscribed = false
                                }
                                return updateBtn()
                            })
                    })
            })
        }
    }, 100)
}

function processResponse(data, action) {
    if (action === 'update') {
        if (typeof data.success === undefined || !data.success) {
            return
        }
        createCookie('no_update', 1, 10)
    } else {
        if (typeof data.success === undefined) {
            $('#notification').append('<p class="erro mt-2 center">Erro desconhecido!</p>')
            if (sub) {
                sub.unsubscribe()
                isSubscribed = false
            }
        } else if (data.success && action === 'add') {
            isSubscribed = true
        } else if (data.success && action === 'remove') {
            isSubscribed = false
        } else if (typeof data.erro !== undefined) {
            $('#notification').append('<p class="erro mt-2 center">' + data.erro + '</p>')
            if (sub) {
                sub.unsubscribe()
                isSubscribed = false
            }
        } else {
            $('#notification').append('<p class="erro mt-2 center">Erro desconhecido!</p>')
            if (sub) {
                sub.unsubscribe()
                isSubscribed = false
            }
        }
        return updateBtn()
    }
}