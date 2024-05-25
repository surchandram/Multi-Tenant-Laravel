const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
      './resources/js/**/*.vue',
  ],
  theme: {
    extend: {
        container: {
            center: true,
        },

        fontFamily: {
            inter: ['Inter', ...defaultTheme.fontFamily.sans],
        },

        fontSize: {
            base: '16px',
            sm: ['14px', '20px']
        },

        colors: {
            'purple': {
                600: '#7E3AF2'
            },
            'gray': {
                800: '#1F2A37',
                900: '#111928'
            }
        },

        spacing: {
            '10.5': '42px',
            '172.5': '172.5px'
        },

        height: {
            '715': '715px',
        },

        gap: {
            '74': '74px',
        },

        lineHeight: {
            '60': '60px',
        },

        width: {
            '400': '400px',
        },

        boxShadow: {
            '4xl': '0px 4px 4px 0px rgba(0, 0, 0, 0.25)',
        }
    },
  },
  plugins: [

  ],
}
