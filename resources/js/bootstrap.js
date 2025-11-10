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

// Detect if site is using HTTPS
const isHttps = window.location.protocol === 'https:';

// Configure based on page protocol
const pusherConfig = {
    key: 'local-key',
    wsHost: window.location.hostname, // Use same host as site
    wsPort: isHttps ? 8080 : 8080,
    wssPort: isHttps ? 8080 : 8080,
    enabledTransports: isHttps ? ['wss'] : ['ws'], // Match page protocol
    forceTLS: isHttps, // Use TLS if page is HTTPS
    encrypted: isHttps,
    disableStats: false,
    cluster: '',
    authEndpoint: '/broadcasting/auth',
};

console.log('🔧 Pusher config:', {
    pageProtocol: window.location.protocol,
    wsProtocol: isHttps ? 'wss://' : 'ws://',
    host: window.location.hostname,
    port: 8080,
    config: pusherConfig
});

window.Echo = new Echo({
    broadcaster: 'reverb',
    ...pusherConfig,
});

console.log('✅ Echo initialized for', isHttps ? 'wss://' : 'ws://', window.location.hostname + ':8080');
