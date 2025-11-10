const CACHE_NAME = 'soshemaine-v1';
const OFFLINE_URLS = [
  '/',
  '/css/site.css',
  '/css/tokens.css',
  '/js/main.js',
  '/index.php'
];
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(OFFLINE_URLS))
  );
});
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => response || fetch(event.request).catch(() => caches.match('/index.php')))
  );
});
