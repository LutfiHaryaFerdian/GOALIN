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
                display: ['"Feather Bold"', 'Nunito', 'sans-serif'],
                sans:    ['Nunito', 'sans-serif'],
            },
            colors: {
                ink: {
                    DEFAULT: '#3C3C3C',
                    muted:   '#777777',
                    2:       '#777777',
                    3:       '#777777',
                },
                green: {
                    DEFAULT: '#58cc02',
                    dark:    '#49ad00',
                    shadow:  '#58a700',
                    light:   '#f7f7f7',
                    border:  '#e5e5e5',
                },
                line: {
                    DEFAULT: '#e5e5e5',
                    light:   '#ebebeb',
                },
                surface: {
                    DEFAULT: '#ffffff',
                    1:       '#f7f7f7',
                    2:       '#ebebeb',
                },
                canvas:  '#ffffff',

                // keep legacy aliases so existing blade files don't break
                primary: {
                    DEFAULT: '#58cc02',
                    dark:    '#49ad00',
                    shadow:  '#58a700',
                    light:   '#f7f7f7',
                },
                secondary: {
                    DEFAULT: '#1cb0f6',
                    dark:    '#0f9fd9',
                },
                accent: {
                    yellow: '#ffc800',
                    red:    '#ff4b4b',
                    purple: '#ce82ff',
                },
                streak: '#ff9600',
                xp:     '#ffc800',
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
