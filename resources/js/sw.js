'use strict'

self.addEventListener('push', (event) => {
    const data = event.data.json()
    const options = {
        body: data.msg,
        icon: 'img/icon.png',
        badge: 'img/icon.png',
        data: {url: data.link}
    }
    if (typeof data.img !== undefined) {
        options.image = data.img
    }
    event.waitUntil(self.registration.showNotification(data.title, options))
})

self.addEventListener('notificationclick', (event) => {
    event.notification.close()
    event.waitUntil(clients.matchAll({
        type: 'window'
    }).then((clientList) => {
        for (let i = 0; i < clientList.length; i++) {
            let client = clientList[i]
            if (client.url === event.notification.data.url && 'focus' in client)
                return client.focus()
        }
        if (clients.openWindow)
            return clients.openWindow('https://ofertas.leone.tec.br' + event.notification.data.url)
    }))
})