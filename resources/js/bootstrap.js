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

// Debug Pusher
window.Pusher.logToConsole = true;

// Configure Echo for local development (force ws:// not wss://)
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: 'local-key',
    wsHost: 'localhost',
    wsPort: 8080,
    wssPort: null, // Disable secure port completely
    forceTLS: false,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws'],
    authEndpoint: '/broadcasting/auth',
    cluster: '', // Prevent Pusher cloud fallback
    // Pusher-specific options to disable TLS completely
    useTLS: false,
});

console.log('🔌 Echo configured for ws://localhost:8080 (no TLS, ws only)');
