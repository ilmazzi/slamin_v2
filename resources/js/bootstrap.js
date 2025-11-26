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

console.log('🔧 Reverb config:', {
    scheme: reverbScheme,
    host: reverbHost,
    port: reverbPort,
    key: reverbKey
});

// Test Pusher directly without Echo
try {
    const pusher = new Pusher(reverbKey, {
        wsHost: reverbHost,
        wsPort: reverbPort,
        wssPort: reverbPort,
        forceTLS: reverbScheme === 'https',
        enabledTransports: reverbScheme === 'https' ? ['wss'] : ['ws'],
        cluster: 'mt1',
        disableStats: true,
    });
    
    console.log('✅ Pusher initialized directly:', pusher);
    
    // Now initialize Echo
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: reverbKey,
        wsHost: reverbHost,
        wsPort: reverbPort,
        wssPort: reverbPort,
        forceTLS: reverbScheme === 'https',
        enabledTransports: reverbScheme === 'https' ? ['wss'] : ['ws'],
        cluster: 'mt1',
        disableStats: true,
    });
    
    console.log('✅ Echo initialized');
} catch (error) {
    console.error('❌ Error initializing Pusher/Echo:', error);
}
