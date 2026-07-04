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
        colors: {
            navy: '#1E3A5F',
            emerald: {
                50: '#ECFDF5',
                100: '#D1FAE5',
                500: '#10B981',
                600: '#059669',
                700: '#047857',
            },
        },
    },
},

    plugins: [forms],
};
