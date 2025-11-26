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

// Get Reverb config from environment variables
const reverbKey = import.meta.env.VITE_REVERB_APP_KEY || 'local-key';
const reverbHost = import.meta.env.VITE_REVERB_HOST || window.location.hostname;
const reverbPort = parseInt(import.meta.env.VITE_REVERB_PORT || (window.location.protocol === 'https:' ? 443 : 80));
const reverbScheme = import.meta.env.VITE_REVERB_SCHEME || (window.location.protocol === 'https:' ? 'https' : 'http');

// Configure Pusher
const pusherConfig = {
    key: reverbKey,
    wsHost: reverbHost,
    wsPort: reverbScheme === 'https' ? 443 : reverbPort,
    wssPort: reverbScheme === 'https' ? 443 : reverbPort,
    wsPath: '/app',
    enabledTransports: reverbScheme === 'https' ? ['wss'] : ['ws'],
    forceTLS: reverbScheme === 'https',
    encrypted: reverbScheme === 'https',
    disableStats: false,
    cluster: '',
    authEndpoint: '/broadcasting/auth',
};

console.log('🔧 Pusher config:', {
    scheme: reverbScheme,
    host: reverbHost,
    port: reverbPort,
    wsUrl: `${reverbScheme === 'https' ? 'wss' : 'ws'}://${reverbHost}:${reverbPort}`,
    config: pusherConfig
});

window.Echo = new Echo({
    broadcaster: 'reverb',
    ...pusherConfig,
});

console.log('✅ Echo initialized');
