let staticCacheName="v2.3.6";self.addEventListener("install",(t=>{t.waitUntil(caches.open(staticCacheName).then((t=>t.addAll(["css/app.min.css","js/app.min.js","js/bootstrap.bundle.min.js","js/jquery.min.js","css/bootstrap.min.css","json/manifest.json"]))))})),self.addEventListener("activate",(t=>{t.waitUntil(caches.keys().then((t=>Promise.all(t.filter((t=>t.startsWith("v"))).filter((t=>t!==staticCacheName)).map((t=>caches.delete(t)))))))})),self.addEventListener("fetch",(t=>{t.respondWith(caches.match(t.request).then((e=>{if(e)return e;let i=t.request.clone();return fetch(i)})))})),self.addEventListener("push",(t=>{const e=t.data.json(),i={body:e.msg,icon:"img/icon.png",badge:"img/icon.png",data:{url:e.link}};void 0!==e.img&&(i.image=e.img),t.waitUntil(self.registration.showNotification(e.title,i))})),self.addEventListener("notificationclick",(t=>{t.notification.close(),t.waitUntil(clients.matchAll({type:"window"}).then((e=>{for(let i=0;i<e.length;i++){let n=e[i];if(n.url==t.notification.data.url&&"focus"in n)return n.focus()}if(clients.openWindow)return clients.openWindow("https://ofertas.leone.tec.br"+t.notification.data.url)})))}));
