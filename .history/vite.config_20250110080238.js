import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [rea
        laravel({
            input: [
                'resources/css/app.css',    // Tailwind CSS
                'resources/sass/app.scss', // Include the SCSS file
                'resources/js/app.jsx',     // React app
            ],
            refresh: true, // Enables auto-refresh in development
        }),
        react(), // React plugin for JSX support
    ],
});
