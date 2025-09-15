import './bootstrap.js'
import {createCookie, errorAlert, getCSRF, submit} from './functions'

const options = {hour: 'numeric', minute: 'numeric', year: 'numeric', month: '2-digit', day: '2-digit'};
const allPrefer = document.querySelector('#all');
const igShareDiv = document.querySelector('#ig-share');
const notificationInput = document.querySelector('#notificacao');
const prefersDiv = document.querySelector('#prefers');
const prefersInputs = document.querySelectorAll("#prefers input[type='checkbox']");
const paraInput = document.querySelector('#para');
const preferInputs = document.querySelectorAll('.prefer');

String.prototype.strstr = function (search) {
    let position = this.indexOf(search);
    if (position === -1) {
        return this;
    }
    return this.substring(0, position);
};

function igShare(selector) {
    const element = document.querySelector(selector);
    const title = element.querySelector('.product-title').innerHTML;
    const desc = element.querySelector('.description')?.innerHTML;
    const priceFrom = element.querySelector('.price-from')?.innerHTML;
    const code = element.querySelector('.code-text')?.value;

    document.querySelector('#product-title').innerHTML = title;
    const productImage = document.querySelector('#product-image');
    productImage.src = element.querySelector('.product-image').src;
    productImage.alt = title;

    const priceFromDiv = document.querySelector('#price-from');
    if (priceFrom) {
        document.querySelector('#product-price-from').innerHTML = priceFrom;
        priceFromDiv.style.display = 'block';
    } else {
        priceFromDiv.style.display = 'none';
    }

    document.querySelector('#installment').innerHTML = element.querySelector('.installment').innerHTML;

    const productDescDiv = document.querySelector('#product-desc');
    if (desc) {
        productDescDiv.innerHTML = desc;
        productDescDiv.style.display = 'block';
    } else {
        productDescDiv.style.display = 'none';
    }

    document.querySelector('#product-code').style.display = code ? 'block' : 'none';
    document.querySelector('#product-price-to').innerHTML = element.querySelector('.pricing-card-title').innerHTML;
    document.querySelector('#share-link').innerHTML = getUrl(selector);
    igShareDiv.classList.remove('d-none');
}

function escondeCupom(cupom) {
    cupom = String(cupom);
    let code = cupom.substring(0, cupom.length - 2);
    return code.replace(/./g, '*') + cupom.substring(cupom.length - 2);
}

function getText(selector) {
    const element = document.querySelector(selector);
    const desc = element.querySelector('.description')?.innerHTML;
    let text = element.querySelector('.pricing-card-title').innerHTML;
    const priceFrom = element.querySelector('del')?.innerHTML;
    const title = element.querySelector('.product-title').innerHTML;
    const cupom = element.querySelector('.code-text')?.value;

    if (text !== 'Grátis') {
        text = `Por apenas ${text}!`;
    }
    if (priceFrom) {
        text = `De: ${priceFrom}\n\n${text}`;
    }
    if (cupom) {
        text += `\n\nCupom: ${escondeCupom(cupom)}`;
    }
    text = `${title}.\n\n${text}`;
    if (desc) {
        text += `\n\n${desc}`;
    }
    return text;
}

function getTextCupom(selector) {
    const element = document.querySelector(selector);
    let text = `${element.querySelector('.card-title').innerHTML} no(a) ${element.querySelector('.loja-image').alt}`;
    const validity = element.querySelector('.coupon-validity').innerHTML;
    let cupom = `Cupom: ${escondeCupom(element.querySelector('.code-text').value)}`;
    text += `\n\n${validity}\n\n${cupom}`;
    return text;
}

function getUrl(element) {
    return `https://para.promo/${btoa(element.replace('#promo-', 'o-')).replace('=', '')}`;
}

function getUrlCupom(element) {
    return `https://para.promo/${btoa(element.replace('#cupom-', 'c-')).replace('=', '')}`;
}

function copyText(text, url = false) {
    navigator.clipboard.writeText(text).then(() => {
        if (url) window.open(url);
        else {
            let toast = new bootstrap.Toast(document.getElementById('copy-success'));
            toast.show();
        }
    }, () => {
        if (url) window.open(url);
        else errorAlert('Não foi possível copiar, copie manualmente!');
    });
}

function topo() {
    window.scrollTo({top: 0, behavior: 'smooth'});
}

function getReCaptcha(token) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.id = 'g-recaptcha-response';
    input.name = 'g-recaptcha-response';
    input.value = token;
    return input;
}

function redirectUrl() {
    let textBox = document.querySelector('#url');
    let url = textBox.value;

    url = url.strstr('?');
    window.open(`/redirect?url=${url}`);

    textBox.value = '';
    textBox.parentElement.parentElement.classList.remove('was-validated');
}

function createAndSubmitForm(action, csrf, recaptcha) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = action;
    form.id = 'pesquisar';
    form.appendChild(csrf);
    form.appendChild(recaptcha);
    document.body.appendChild(form);
    form.requestSubmit();
    document.body.removeChild(form);
}

function pesquisar(q, token) {
    createAndSubmitForm(`/search/${q}`, getCSRF(), getReCaptcha(token));
}

function paginateSearch(href, token) {
    createAndSubmitForm(href, getCSRF(), getReCaptcha(token));
}

async function sendForm(id, token, onSuccess) {
    const form = document.querySelector(`#${id}`);
    const btn = document.querySelector(`#${id}-submit`);
    const errorId = `#error-${id}`;
    const errorDiv = document.querySelector(errorId);

    if (onSuccess === undefined) {
        onSuccess = (data) => {
            if (typeof data.success === 'undefined') {
                errorDiv.innerHTML = '<p class="alert alert-danger">Erro desconhecido :(</p>';
                errorDiv.classList.remove('d-none');
            } else if (typeof data.message !== 'undefined') {
                if (!data.success) {
                    errorDiv.innerHTML = `<p class="alert alert-danger">${data.message}</p>`;
                    errorDiv.classList.remove('d-none');
                } else {
                    errorDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    errorDiv.classList.remove('d-none');
                }
            }
        };
    }

    const formData = new FormData(form);
    const values = Object.fromEntries(formData.entries());
    values['_token'] = CSRF;
    values['g-recaptcha-response'] = token;

    const value = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'Aguarde ...';
    form.classList.remove('was-validated');
    errorDiv.classList.add('d-none');

    try {
        const response = await axios.post(form.getAttribute('action'), values);
        onSuccess(response.data);
    } catch (error) {
        errorDiv.innerHTML = '<p class="alert alert-danger">Não foi possível enviar os dados, tente novamente!</p>';
        errorDiv.classList.remove('d-none');
    } finally {
        btn.innerHTML = value;
        btn.disabled = false;
    }
}

function getToken(action, id, type = 'ajax') {
    let text, btn;
    const changeBtn = (type === 'ajax');

    if (changeBtn) {
        btn = document.querySelector(`#${id}-submit`);
        text = btn.innerHTML;
        btn.innerHTML = 'Verificando ...';
        btn.disabled = true;
    }

    let interval = setInterval(function () {
        if (window.grecaptcha) {
            clearInterval(interval);
            grecaptcha.ready(() => {
                grecaptcha.execute(KEY_V3_RECAPTCHA, {action: action})
                    .then((token) => {
                        if (changeBtn) {
                            btn.innerHTML = text;
                        }
                        if (type === 'ajax') {
                            sendForm(id, token);
                        } else if (type === 'search') {
                            let q = document.querySelector('#q').value;
                            pesquisar(q, token);
                        } else if (type === 'paginate') {
                            paginateSearch(id, token);
                        }
                    });
            });
        }
    }, 100);
}

function getData(e) {
    let element, text, url;
    const promo = e.closest('.promo');
    if (promo) {
        element = `#${promo.id}`;
        text = getText(element);
        url = getUrl(element);
    } else {
        const cupom = e.closest('.cupom');
        element = `#${cupom.id}`;
        text = `\n${getTextCupom(element)}`;
        url = getUrlCupom(element);
    }
    return {'url': url, 'text': text};
}

document.querySelectorAll('.ajax-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!this.checkValidity()) {
            e.stopPropagation();
        } else {
            let action = this.dataset.action;
            if (action === 'search') getToken(action, this.id, action);
            else getToken(action, this.id);
        }
        this.classList.add('was-validated');
    });
});

document.querySelectorAll('.needs-validation').forEach(form => {
    form.addEventListener('submit', function (e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();

            this.classList.add('was-validated');
        } else {
            this.classList.add('was-validated');

            if (this.id === 'deeplink') {
                e.preventDefault()

                redirectUrl();
            }
        }

    });
});

if (navigator.share) {
    document.querySelectorAll('.plus-share').forEach(el => el.classList.remove('d-none'));
}

document.querySelector('#accept')?.addEventListener('click', () => {
    createCookie('accept', 'true', 365);
    const cookieBanner = document.querySelector('#aviso-cookie');
    cookieBanner.style.transition = 'opacity 0.5s ease';
    cookieBanner.style.opacity = '0';
    setTimeout(() => {
        cookieBanner.style.display = 'none';
    }, 500);
});

document.querySelectorAll('.igs').forEach(btn => {
    btn.addEventListener('click', function () {
        alert('Tire print e compartilhe nas suas stories, para fechar dê um duplo clique!');
        igShare(`#${this.closest('.promo').id}`);
    });
});

document.querySelectorAll('.mre').forEach(btn => {
    btn.addEventListener('click', function () {
        let {text, url} = getData(this);
        navigator.share({text, url});
    });
});

document.querySelectorAll('.cpy').forEach(btn => {
    btn.addEventListener('click', function () {
        let {text, url} = getData(this);
        text += `\n\n${url}`;
        copyText(text);
    });
});

document.querySelectorAll('.wpp').forEach(btn => {
    btn.addEventListener('click', function () {
        let {text, url} = getData(this);
        text += `\n\n${url}`;
        window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`);
    });
});

document.querySelectorAll('.tlg').forEach(btn => {
    btn.addEventListener('click', function () {
        let {text, url} = getData(this);
        window.open(`https://telegram.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`);
    });
});

document.querySelectorAll('.twt').forEach(btn => {
    btn.addEventListener('click', function () {
        let {text, url} = getData(this);
        text += '\n';
        window.open(`https://twitter.com/share?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`);
    });
});

if (igShareDiv) {
    igShareDiv.addEventListener('dblclick', () => igShareDiv.classList.add('d-none'));
}

document.querySelectorAll('.copy-redirect').forEach(btn => {
    btn.addEventListener('click', function () {
        const promo = this.closest('.promo');
        const elementSelector = promo ? `#${promo.id}` : `#${this.closest('.cupom').id}`;
        const url = this.dataset.link;
        const code = document.querySelector(elementSelector).querySelector('.code-text').value;

        copyText(code, url);
    });
});

document.querySelector('#i-notification')?.addEventListener('click', () => {
    document.querySelector('#notification').classList.add('d-none');
    createCookie('no_notification', 1, 60);
});

if (window.location.pathname.includes('/search')) {
    document.querySelectorAll('.page-link, .filtros').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            let href = this.getAttribute('href');
            getToken('paginate', href, 'paginate');
        });
    });
}

prefersInputs.forEach(input => {
    input.addEventListener('change', function () {
        const isAnyChecked = Array.from(prefersInputs).some(el => el.checked);
        if (isAnyChecked) {
            paraInput.disabled = true;
            paraInput.removeAttribute('required');
        } else {
            paraInput.disabled = false;
            paraInput.setAttribute('required', 'required');
        }
    });
});

if (allPrefer) {
    allPrefer.addEventListener('change', () => {
        preferInputs.forEach(input => input.checked = allPrefer.checked);
    });
}

if (notificationInput) {
    notificationInput.addEventListener('change', () => {
        if (notificationInput.checked) {
            prefersDiv.classList.remove('d-none');
            prefersDiv.classList.add('d-md-flex');
            prefersInputs.forEach(input => input.checked = true);
        } else {
            prefersDiv.classList.add('d-none');
            prefersInputs.forEach(input => input.checked = false);
        }
    });
}

preferInputs.forEach(input => {
    input.addEventListener('change', function () {
        const allAreChecked = Array.from(preferInputs).every(check => check.checked);
        if (allPrefer) allPrefer.checked = allAreChecked;
    });
});

document.querySelector('#btn-topo')?.addEventListener('click', topo);
