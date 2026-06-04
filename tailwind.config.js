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
                sans:    ['"DM Sans"', 'sans-serif'],
            },
            colors: {
                forest:  '#0D3B2E',
                lime:    '#C6FF00',
                charcoal:'#1A1A1A',
                canvas:  '#F5F5F0',
                muted:   '#717974',
                error:   '#BA1A1A',
                surface: '#FFFFFF',
                // legacy aliases so existing components don't break
                ink: {
                    DEFAULT: '#1A1A1A',
                    muted:   '#717974',
                },
                primary: {
                    DEFAULT: '#0D3B2E',
                    dark:    '#0a2e23',
                    light:   '#F5F5F0',
                },
                field:   'rgba(26,26,26,0.1)',
            },
            borderRadius: {
                DEFAULT: '0px',
                none:    '0px',
                sm:      '0px',
                md:      '0px',
                lg:      '0px',
                xl:      '0px',
                '2xl':   '0px',
                '3xl':   '0px',
                full:    '9999px', // used only for avatar-circle class
            },
            boxShadow: {
                none:    'none',
                DEFAULT: 'none',
                sm:      'none',
                md:      'none',
                lg:      'none',
                xl:      'none',
                '2xl':   'none',
                inner:   'none',
            },
            maxWidth: {
                '8xl': '1280px',
            },
        },
    },

    plugins: [forms],
};
