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
            sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
        },
            colors: {
                brand: {
                    50:  '#f2fbf9', // Background sangat muda (untuk kartu/ikon)
                    100: '#e0f5f0',
                    200: '#c2eae2',
                    300: '#93d7ca',
                    400: '#5fbdae',
                    500: '#3ba393', // Warna utama (lebih cerah & modern)
                    600: '#2b8577', // Hover state
                    700: '#246c62',
                    800: '#21564f',
                    900: '#1e4842',
            },
        },
    },
},

    plugins: [forms],
};
