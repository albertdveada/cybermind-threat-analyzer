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
                'alien-gold': '#D2B26E',
                'alien-dark': '#212121',
                'alien-light-gray': '#e0e0e0',
                'alien-mid-gray': '#b0b0b0',
                'alien-dark-gray': '#383838',
                'alien-hover-dark': '#4c4c4c',
                'alien-teal': '#03d4b8',
                'alien-border-gray': '#444',
                'alien-placeholder': '#666666',
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                oxanium: ['Oxanium', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};
