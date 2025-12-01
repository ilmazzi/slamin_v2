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

// Determina l'host Reverb basato sull'host corrente
const getReverbHost = () => {
    const hostname = window.location.hostname;
    
    // In produzione usa slamin.it
    if (hostname === 'slamin.it' || hostname === 'www.slamin.it') {
        return 'slamin.it';
    }
    
    // In locale usa l'host corrente (slamin_v2.test)
    return hostname;
};

// Determina lo schema basato sull'host
const getReverbScheme = () => {
    const hostname = window.location.hostname;
    return (hostname === 'slamin.it' || hostname === 'www.slamin.it') ? 'https' : 'http';
};

const reverbHost = import.meta.env.VITE_REVERB_HOST || getReverbHost();
const reverbScheme = import.meta.env.VITE_REVERB_SCHEME || getReverbScheme();
const isTLS = reverbScheme === 'https';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: reverbHost,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? (isTLS ? 443 : 80),
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: isTLS,
    enabledTransports: ['ws', 'wss'],
});
