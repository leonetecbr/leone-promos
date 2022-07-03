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

function deleteCookie(cookieName) {
    createCookie(cookieName, '', -1)
}

function getPrefer(endpoint) {
    $.ajax({
        url: '/prefer/get',
        data: JSON.stringify({'endpoint': endpoint, '_token': CSRF}),
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
            if (checked === data.pref.length) {
                $('#all').attr('checked', true)
            }
            $('#preferencias').removeClass('d-none')
        } else {
            if (typeof data.message !== 'undefined') {
                errorAlert(data.message)
            } else {
                errorAlert('Falha')
            }
        }
    }).fail(() => {
        errorAlert('Falha')
    })
}

function errorAlert(message) {
    $('#error-message').html(message)
    let toast = new bootstrap.Toast(document.getElementById('error-alert'))
    toast.show()
}

function getPrefer(endpoint) {
    $.ajax({
        url: '/prefer/get',
        data: JSON.stringify({'endpoint': endpoint, '_token': CSRF}),
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
            if (checked === data.pref.length) {
                $('#all').attr('checked', true)
            }
            $('#preferencias').removeClass('d-none')
        } else {
            if (typeof data.message !== 'undefined') {
                errorAlert(data.message)
            } else {
                errorAlert('Falha')
            }
        }
    }).fail(() => {
        errorAlert('Falha')
    })
}

function errorAlert(message) {
    $('#error-message').html(message)
    let toast = new bootstrap.Toast(document.getElementById('error-alert'))
    toast.show()
}