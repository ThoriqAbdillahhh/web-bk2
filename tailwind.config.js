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
                    50: '#fff7f2',
                    100: '#ffeadc',
                    200: '#ffd2b8',
                    300: '#f7b28d',
                    400: '#e9895e',
                    500: '#d9683d',
                    600: '#c45129',
                    700: '#ad431f',
                    800: '#8b371d',
                    900: '#702f1d',
                },
            },
        },
    },

    plugins: [forms],
};
