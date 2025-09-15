function createCookie(name, value, days) {
    let expires;

    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 1000));
        expires = '; expires=' + date.toGMTString();
    } else {
        expires = '';
    }

    document.cookie = `${name}=${value}${expires}; path=/`;
}

function deleteCookie(cookieName) {
    createCookie(cookieName, '', -1);
}

async function getPrefer(endpoint) {
    const payload = {
        'endpoint': endpoint,
        '_token': CSRF
    };

    try {
        const response = await axios.post('/prefer/get', payload);
        const data = response.data;

        if (data.success) {
            let checkedCount = 0;
            for (let i = 0; i < data.pref.length; i++) {
                if (data.pref[i]) {
                    document.querySelector('#p' + (i + 1)).checked = true;
                    checkedCount++;
                }
            }

            if (checkedCount === data.pref.length) {
                document.querySelector('#all').checked = true;
            }

            document.querySelector('#preferencias').classList.remove('d-none');
        } else {
            errorAlert(data.message || 'Falha ao obter preferências.');
        }
    } catch (error) {
        console.error('Falha na requisição:', error);
        errorAlert('Falha na comunicação com o servidor.');
    }
}

function errorAlert(message) {
    // Substitui $('#error-message').html(message)
    const errorMessageElement = document.querySelector('#error-message');

    if (errorMessageElement) {
        errorMessageElement.innerHTML = message;
    }

    const errorAlertElement = document.getElementById('error-alert');
    if (errorAlertElement) {
        const toast = new bootstrap.Toast(errorAlertElement);
        toast.show();
    }
}

function getCSRF() {
    let input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.id = 'token';
    input.setAttribute('name', '_token');
    input.value = CSRF;
    return input;
}

function submit() {
    const csrf = getCSRF();
    const form = document.querySelector('#checkbox');

    if (form) {
        form.appendChild(csrf);
        form.requestSubmit();
    }
}

export {
    createCookie,
    deleteCookie,
    getPrefer,
    errorAlert,
    getCSRF,
    submit
};
