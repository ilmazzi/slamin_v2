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

// Debug logging
window.Pusher.logToConsole = true;

// CRITICAL: Create Pusher instance manually with correct config
const pusherConfig = {
    key: 'local-key',
    wsHost: 'localhost',
    wsPort: 8080,
    wssPort: 8080,
    enabledTransports: ['ws'],
    disabledTransports: ['wss'],
    forceTLS: false,
    encrypted: false,
    disableStats: false,
    cluster: '',
    authEndpoint: '/broadcasting/auth',
};

console.log('🔧 Pusher config:', pusherConfig);

window.Echo = new Echo({
    broadcaster: 'reverb',
    ...pusherConfig,
});

console.log('✅ Echo initialized for ws://localhost:8080');
