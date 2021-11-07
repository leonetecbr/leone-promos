/*let staticCacheName = 'v2.0.0';

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(staticCacheName).then(function(cache) {
      return cache.addAll(
        [
          'css/style.css',
          'js/jquery.min.js',
          'js/funcoes.js',
          'js/notify.js',
          'json/manifest.json'
        ]
      );
    })
  );
});

this.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames
          .filter(cacheName => (cacheName.startsWith('v')))
          .filter(cacheName => (cacheName !== staticCacheName))
          .map(cacheName => caches.delete(cacheName))
      );
    })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.open(staticCacheName).then(function(cache) {
      return cache.match(event.request).then(function (response) {
        return response || fetch(event.request).then(function(response) {
          cache.put(event.request, response.clone());
          return response;
        });
      });
    })
  );
});
*/

/*
*
*  Push Notifications codelab
*  Copyright 2015 Google Inc. All rights reserved.
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      https://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License
*
* Modifications were made to make the code fit my project
*/
'use strict';

self.addEventListener('push', function(event) {
  const data = event.data.json();
  const options = {
    body: data.msg,
    icon: 'img/icon.png',
    badge: 'img/icon.png',
    data: {url: data.link}
  };
  if (typeof data.img !== 'undefined') {
    options.image = data.img;
  }
  event.waitUntil(self.registration.showNotification(data.title, options));
});

self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  event.waitUntil(clients.matchAll({
    type: "window"
  }).then(function(clientList) {
    for (var i = 0; i < clientList.length; i++) {
      var client = clientList[i];
      if (client.url == event.notification.data.url && 'focus' in client)
        return client.focus();
    }
    if (clients.openWindow)
      return clients.openWindow('https://ofertas.leone.tec.br'+event.notification.data.url+'?utm_source=push_notify');
  }));
});