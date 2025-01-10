import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // Keep this if you're using Sass
                'resources/css/app.css',  // Add this to include the CSS file
                'resources/js/app.jsx',   // Keep this for React
            ],
            refresh: true,
        }),
        react(),
    ],
});
