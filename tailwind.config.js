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

            spacing: {
                '32': '8rem',
                '10': '2.5rem',
                '14': '3.5rem',
                '64': '16rem',
                '55': '13.75rem'
            },
            colors: {
                orange: {
                    50: '#f0eae5',
                },
                green: {
                    50: '#e5f4ed',
                },
                brown: {
                    800: '#543b28',
                },
            },

            animation: {
                'fade-in': 'fadeIn 0.5s ease-out'
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 }
                }
            }

        },
    },

    plugins: [forms],
};