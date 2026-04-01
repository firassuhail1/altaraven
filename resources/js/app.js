import './bootstrap';
import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// ─── Alpine.js ───────────────────────────────────────────────────────────────
window.Alpine = Alpine;
Alpine.start();

// ─── Laravel Echo (Reverb) ───────────────────────────────────────────────────
window.Pusher = Pusher;

// Only init Echo if Reverb config is present
const reverbKey = import.meta.env.VITE_REVERB_APP_KEY;
if (reverbKey) {
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key:         reverbKey,
        wsHost:      import.meta.env.VITE_REVERB_HOST    ?? 'localhost',
        wsPort:      import.meta.env.VITE_REVERB_PORT    ?? 8080,
        wssPort:     import.meta.env.VITE_REVERB_PORT    ?? 443,
        forceTLS:   (import.meta.env.VITE_REVERB_SCHEME  ?? 'http') === 'https',
        enabledTransports: ['ws', 'wss'],
    });
}
