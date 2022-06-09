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