import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                display: ['"Barlow Condensed"', 'sans-serif'],
                sans:    ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: {
                    DEFAULT: '#0a0a0a',
                    2:       '#404040',
                    3:       '#737373',
                },
                green: {
                    DEFAULT: '#16a34a',
                    dark:    '#15803d',
                    light:   '#f0fdf4',
                    border:  '#bbf7d0',
                },
                line: {
                    DEFAULT: '#e5e5e5',
                    light:   '#f5f5f5',
                },
                surface: '#ffffff',
                canvas:  '#f8f8f6',

                // keep legacy aliases so existing blade files don't break
                primary: {
                    DEFAULT: '#16a34a',
                    dark:    '#15803d',
                    light:   '#f0fdf4',
                },
                accent:  '#f8f8f6',
                field:   '#e5e5e5',
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
        },
    },

    plugins: [forms],
};
