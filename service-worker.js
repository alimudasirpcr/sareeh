const CACHE_NAME = 'custom-offline-cache-v1';
const TIMESTAMP = new URL(self.location).searchParams.get('ts') || 'default';
const OFFLINE_PAGE_URL = `sareeh/home/offline/${TIMESTAMP}`;

// Injected from your PHP view via <script> or inline config
const OFFLINE_ASSETS = self.__ASSETS__ || [
  '/assets/css/style.css',
  '/assets/js/app.js',
  '/assets/images/logo.png'
];

self.addEventListener('install', event => {
  event.waitUntil(
    (async () => {
      try {
        const cache = await caches.open(CACHE_NAME);
        console.log('[SW] OFFLINE_PAGE_URL', OFFLINE_PAGE_URL );
        // Cache the offline HTML page
        const offlinePageResponse = await fetch(OFFLINE_PAGE_URL, { credentials: 'same-origin' });
        if (!offlinePageResponse.ok) throw new Error('Failed to fetch offline page');
        await cache.put('/offline-page', offlinePageResponse);

        // Cache the additional assets
        await cache.addAll(OFFLINE_ASSETS);

        console.log('[SW] Cached offline page + assets');
      } catch (err) {
        console.error('[SW] Install error:', err);
      }
    })()
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(clients.claim());
});

self.addEventListener('fetch', event => {
  if (event.request.mode === 'navigate') {
    event.respondWith(
      fetch(event.request)
        .catch(() => caches.match('/offline-page'))
    );
  } else {
    event.respondWith(
      caches.match(event.request)
        .then(response => response || fetch(event.request))
    );
  }
});
