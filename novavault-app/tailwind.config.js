import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    950: '#04060d',
                    900: '#070b14',
                    800: '#0e1626',
                    700: '#162038',
                    600: '#1e2a4a',
                },
                gold: {
                    DEFAULT: '#fff6a9',
                    light: '#fffbe0',
                    dark: '#ffdc7b',
                    deep: '#f5c542',
                },
                nv: {
                    blue: '#39b8ff',
                    'blue-dark': '#1d4ed8',
                    accent: '#8b5cf6',
                },
                surface: {
                    DEFAULT: 'rgba(14, 22, 38, 0.72)',
                    dark: 'rgba(10, 18, 32, 0.86)',
                },
                stroke: {
                    DEFAULT: 'rgba(255,255,255,0.10)',
                    bright: 'rgba(255,255,255,0.16)',
                },
            },
            borderRadius: {
                nv: '18px',
                'nv-sm': '14px',
            },
        },
    },

    plugins: [forms],
};
