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
                yasmina: {
                    50: 'var(--yasmina-50)',
                    100: 'var(--yasmina-100)',
                    200: 'var(--yasmina-200)',
                    300: 'var(--yasmina-300)',
                    400: 'var(--yasmina-400)',
                    500: 'var(--yasmina-500)',
                    600: 'var(--yasmina-600)',
                    700: 'var(--yasmina-700)',
                    800: 'var(--yasmina-800)',
                    900: 'var(--yasmina-900)',
                }
            }
        },
    },

    plugins: [forms],
};
