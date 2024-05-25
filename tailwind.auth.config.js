const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/js/components/auth/**/*.vue',
        './resources/js/components/*.{js,vue}',
        './resources/js/layouts/auth.vue',
        './resources/js/layouts/partials/Auth*.vue',
        './resources/js/app/**/*.vue',
        '!./resources/js/app/admin|auth|home/**/*.vue',
        './node_modules/tw-elements/dist/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('tw-elements/dist/plugin')
    ],
};
