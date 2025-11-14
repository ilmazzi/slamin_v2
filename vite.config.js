import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/events-map.css',
                'resources/css/events-index.css',
                'resources/css/event-ticket.css',
                'resources/js/events-map.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
