import {createCookie, deleteCookie, getPrefer} from './functions'

let isSubscribed = false
let swRegistration = null
let sub

const btn = document.querySelector('#notification-btn')
const notificationBanner = document.querySelector('#notification')
const notificationUnsupported = document.querySelector('#notification-unsupported')
const notificationBlocked = document.querySelector('#notification-blocked')
const notificationPreferences = document.querySelector('#preferencias')
const notifyContainer = document.querySelector('#notify')

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

if (btn) {
    if ('serviceWorker' in navigator && 'PushManager' in window) {
        navigator.serviceWorker.register('/sw.js').then((swReg) => {
            swRegistration = swReg
            initializeUI()
        })
    } else {
        btn.textContent = 'Notificações não suportadas'
        notificationUnsupported.classList.remove('d-none')
    }
}

function initializeUI() {
    if (document.cookie.indexOf('no-notification') < 0) {
        notificationBanner.classList.remove('d-none')
    }

    btn.disabled = false
    btn.addEventListener('click', () => {
        btn.disabled = true
        btn.textContent = 'Aguarde ...'
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
                    document.querySelector('#endpoint').value = subscription.endpoint
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
        btn.textContent = 'Notificações bloqueadas'
        btn.disabled = true
        notificationBlocked.classList.remove('d-none')

        if (sub) {
            update('remove')
        }

        return
    }

    btn.disabled = false

    if (isSubscribed) {
        setTimeout(() => {
            createCookie('no-notification', 1, 60)
            notificationBanner.classList.add('d-none')
        }, 1000)
        btn.textContent = 'Desativar notificações'
    } else {
        btn.textContent = 'Ativar notificações'
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
        notificationPreferences.classList.add('d-none')
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
                    .then(async (token) => {
                        const payload = {
                            subscription: sub,
                            action: action,
                            token: token,
                            _token: CSRF
                        }

                        try {
                            const response = await axios.post('/notificacoes/manage', payload)

                            processResponse(response.data, action)

                        } catch (error) {
                            console.error('Axios Error:', error.response || error.message)

                            const errorP = document.createElement('p')
                            errorP.className = 'erro mt-2 center'
                            errorP.textContent = 'Erro desconhecido!'
                            notifyContainer.appendChild(errorP)

                            if (sub) {
                                sub.unsubscribe()
                                isSubscribed = false
                            }

                            return updateBtn()
                        }
                    })
            })
        }
    }, 100)
}

function appendErrorMessage(parent, message) {
    const errorP = document.createElement('p')
    errorP.className = 'erro mt-2 center'
    errorP.textContent = message
    parent.appendChild(errorP)
}

function processResponse(data, action) {
    if (action === 'update') {
        if (typeof data.success === 'undefined' || !data.success) {
            return
        }
        createCookie('no_update', 1, 10)
    } else {
        if (typeof data.success === 'undefined') {
            appendErrorMessage(notificationBanner, 'Erro desconhecido!')
            if (sub) {
                sub.unsubscribe()
                isSubscribed = false
            }
        } else if (data.success && action === 'add') {
            isSubscribed = true
        } else if (data.success && action === 'remove') {
            isSubscribed = false
        } else if (typeof data.erro !== 'undefined') {
            appendErrorMessage(notificationBanner, data.erro)
            if (sub) {
                sub.unsubscribe()
                isSubscribed = false
            }
        } else {
            appendErrorMessage(notificationBanner, 'Erro desconhecido!')
            if (sub) {
                sub.unsubscribe()
                isSubscribed = false
            }
        }
        return updateBtn()
    }
}
