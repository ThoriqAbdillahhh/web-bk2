import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#fff8f3',
                    100: '#ffede2',
                    200: '#ffd7c0',
                    300: '#ffc09a',
                    400: '#f39b70',
                    500: '#db7045',
                    600: '#c45129',
                    700: '#a94220',
                    800: '#87371e',
                    900: '#6d2e1d',
                },
            },
        },
    },

    plugins: [forms],
};
