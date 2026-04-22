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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                barbie: {
                    50: '#fff0f7',
                    100: '#ffe4f2',
                    200: '#ffc9e7',
                    300: '#ff9ed1',
                    400: '#ff64b1',
                    500: '#e0218a',
                    600: '#c2146e',
                    700: '#a20e58',
                    800: '#86104a',
                    900: '#701140',
                }
            }
        },
    },

    plugins: [forms],
};
