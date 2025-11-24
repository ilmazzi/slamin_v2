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
                'resources/js/events-map.js',
                'resources/css/article-modal.css',
                'resources/css/notification-animation.css',
                'resources/css/profile.css',
                'resources/js/profile.js',
                'resources/css/groups.css',
                'resources/css/forum.css',
                'resources/js/forum.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
