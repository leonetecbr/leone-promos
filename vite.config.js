import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/bootstrap.scss',
                'node_modules/bootstrap-icons/font/bootstrap-icons.css',
                'node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff',
                'node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff2',
            ],
            refresh: true,
        }),
    ],
});
