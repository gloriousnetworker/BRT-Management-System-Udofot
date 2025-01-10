import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',  // Ensure this CSS is included
                'resources/js/app.jsx',   // Use app.jsx for React
            ],
            refresh: true, // Enables auto-refresh in development
        }),
        react(), // Include React plugin for JSX support
    ],
});
