const CACHE_NAME = 'soshemain-cache-v1';
const URLS_TO_CACHE = [
  '/',
  '/index.php',
  '/about.php',
  '/services.php',
  '/products.php',
  '/blog.php',
  '/contact.php',
  '/css/site.css',
  '/js/main.js'
];

self.addEventListener('install', event => {
  event.waitUntil(caches.open(CACHE_NAME).then(cache => cache.addAll(URLS_TO_CACHE)));
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => Promise.all(keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))))
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => response || fetch(event.request))
  );
});
