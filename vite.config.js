import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css'  ,'resources/js/app.js',
    'resources/js/jadwal-calendar.js','resources/css/maintenance.css',
    'resources/js/maintenance-modal.js'],
            refresh: true,
        }),
    ],
});
