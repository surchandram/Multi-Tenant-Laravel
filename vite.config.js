import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import svgLoader from 'vite-svg-loader';
const path = require('path');

export default defineConfig({
    plugins: [
        svgLoader({
            svgo: false,
        }),
        laravel({
            input: [
                'node_modules/bootstrap-icons/font/bootstrap-icons.css',
                'resources/css/landing.css',
                'resources/js/app.js',
                'resources/css/main.css',
                'resources/js/main.js',
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/tailapp.css',
                'resources/css/tailadmin.css',
                'resources/js/tailadmin.js',
            ],
            refresh: false,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    optimizeDeps: {
        includes: [
            'lodash',
            'axios',
            'perfect-scrollbar',
            'alpinejs',
            'vue',
            '@inertiajs/inertia-vue3',
            'laravel-vite-plugin/inertia-helpers',
            '@inertiajs/progress',
            'bootstrap-icons',
            'tw-elements',
            'choices.js',
            'currency.js',
            'flatpickr',
            'slugify',
            'sweetalert2',
        ],
    },
});
