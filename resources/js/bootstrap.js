import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Configure Echo for local development (force ws:// not wss://)
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: 'local-key',
    wsHost: 'localhost',
    wsPort: 8080,
    forceTLS: false, // Disable TLS for local development
    enabledTransports: ['ws'], // ONLY ws, NOT wss (no secure websocket)
    disableStats: true,
    encrypted: false,
    authEndpoint: '/broadcasting/auth',
});

console.log('🔌 Echo configured for ws://localhost:8080 (no TLS, ws only)');
