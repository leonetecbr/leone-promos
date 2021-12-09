let staticCacheName = 'v2.3.5'

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(staticCacheName).then(function(cache) {
      return cache.addAll(
        [
          'css/app.min.css',
          'css/bootstrap.min.css.map',
          'js/app.min.js',
          'js/bootstrap.bundle.min.js',
          'js/bootstrap.bundle.min.js.map',
          'js/jquery.min.js',
          'js/jquery.min.map',
          'css/bootstrap.min.css',
          'img/logo.png',
          'json/manifest.json'
        ]
      )
    })
  )
})

this.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames
          .filter(cacheName => (cacheName.startsWith('v')))
          .filter(cacheName => (cacheName !== staticCacheName))
          .map(cacheName => caches.delete(cacheName))
      )
    })
  )
})

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if (response) {
          return response
        }

        let fetchRequest = event.request.clone()

        return fetch(fetchRequest)
      })
    )
})

'use strict'

self.addEventListener('push', function(event) {
  const data = event.data.json()
  const options = {
    body: data.msg,
    icon: 'img/icon.png',
    badge: 'img/icon.png',
    data: {url: data.link}
  }
  if (typeof data.img !== 'undefined') {
    options.image = data.img
  }
  event.waitUntil(self.registration.showNotification(data.title, options))
})

self.addEventListener('notificationclick', function(event) {
  event.notification.close()
  event.waitUntil(clients.matchAll({
    type: "window"
  }).then(function(clientList) {
    for (let i = 0; i < clientList.length; i++) {
      let client = clientList[i]
      if (client.url == event.notification.data.url && 'focus' in client)
        return client.focus()
    }
    if (clients.openWindow)
      return clients.openWindow('https://ofertas.leone.tec.br'+event.notification.data.url)
  }))
})
