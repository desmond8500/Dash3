import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        cors: true, // Active les CORS
        // host: 'localhost',
        // port: 5173,
    },
    optimizeDeps: {
        include: ['jquery', 'lightbox2'],
    },
});
