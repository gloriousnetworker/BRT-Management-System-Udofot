import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',  // Keep SCSS as input
                'resources/js/app.js',      // Keep JS as input
            ],
            refresh: true,
        }),
        react(),
    ],
    // Make sure Vite knows where to output the CSS
    build: {
        manifest: true, // Ensure that manifest is generated
        rollupOptions: {
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
        }
    }
});
