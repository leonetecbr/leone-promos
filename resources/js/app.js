import './bootstrap'

const KEY_V3_RECAPTCHA = import.meta.env.VITE_PUBLIC_RECAPTCHA_V3
const KEY_VAPID_PUBLIC = import.meta.env.VITE_VAPID_PUBLIC_KEY
const newProfilePicture = $('#newProfilePicture')

$('#accept').on('click', () => {
    createCookie('accept', true, 365)
    $('#alertCookie').fadeOut()
})

$('#btnTop').on('click', () => $('html, body').animate({scrollTop: 0}, 800))

$('#showPass').on('click', () => {
    const passwordInput = $('#password'), icon = $('#iconShowPass'), text = $('#textShowPass')

    if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text')
        icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill')
        text.html('Esconder')
    } else {
        passwordInput.attr('type', 'password')
        icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill')
        text.html('Mostrar')
    }
})

$('#updateProfilePicture').on('click', () => newProfilePicture.trigger('click'))

newProfilePicture.on('change', () => $('#newPictureForm').submit())

$('.needs-validation').on('submit', function (e) {
    if (!this.checkValidity()) {
        e.preventDefault()
        e.stopPropagation()

        const toastError = $('#errorToast'), message = $('#errorMessage')

        message.html('Preencha corretamente!')
        new bootstrap.Toast(toastError).show()
    } else {
        e.preventDefault()
        let action = $(this).data('action')
        getToken(action, this.id)
            .then(token => {
                $(this).append(`<input type="hidden" name="grecaptcha" value="${token}">`)
                this.submit()
            })
    }

    this.classList.add('was-validated')
})

$('.simple-validation').on('submit', function (e) {
    if (!this.checkValidity()) {
        e.preventDefault()
        e.stopPropagation()
    }

    this.classList.add('was-validated')
})

if (navigator.share) $('.mre').removeClass('d-none')

$('.share').on('click', function () {
    let type
    const types = ['wpp', 'tlg', 'twt', 'cpy', 'mre']
    let {text, url} = getData(this)

    for (let i = 0; i < types.length; i++) {
        if (this.classList.contains(types[i])) {
            type = types[i]
            break
        }
    }

    alert(type)
})

function createCookie(name, value, days) {
    let expires = ''

    if (days) {
        let date = new Date()
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
        expires = '; expires=' + date.toGMTString()
    }

    document.cookie = `${name}=${value}${expires}; path=/`
}

function sleep(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds))
}

async function getToken(action, id) {
    let text, btn, response

    btn = $(`#${id}Submit`)
    text = btn.html()
    btn.html('Verificando ...').attr('disabled', true)

    while (!window.grecaptcha) {
        await sleep(100)
    }

    response = await grecaptcha.execute(KEY_V3_RECAPTCHA, {action: action})

    btn.html(text).attr('disabled', false)
    return response
}

function getData(e) {
    let element, text, url

    // Se for uma promoção
    if (($(e).closest('.promo').attr('id') !== undefined)) {
        element = '#' + $(e).closest('.promo').attr('id')
        text = getText(element)
        url = getUrl(element)
    } else { // Se for um cupom
        element = '#' + $(e).closest('.cupom').attr('id')
        text = '\n' + getTextCupom(element)
        url = getUrlCupom(element)
    }

    return {'url': url, 'text': text}
}
