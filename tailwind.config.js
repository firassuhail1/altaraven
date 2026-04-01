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
                sans:    ['Barlow', ...defaultTheme.fontFamily.sans],
                display: ['Bebas Neue', 'Impact', ...defaultTheme.fontFamily.sans],
                mono:    ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                'ar-black':  '#080808',
                'ar-dark':   '#0f0f0f',
                'ar-gray':   '#1a1a1a',
                'ar-muted':  '#2a2a2a',
                'ar-border': '#2f2f2f',
                'ar-text':   '#e8e6e1',
                'ar-text2':  '#9a9994',
                'ar-red':    '#c0392b',
                'ar-red2':   '#e74c3c',
                'ar-white':  '#f0ede8',
            },
            animation: {
                'fade-in':     'fadeIn 0.6s ease forwards',
                'slide-up':    'slideUp 0.7s ease forwards',
                'slide-right': 'slideRight 0.5s ease forwards',
                'pulse-red':   'pulseRed 2s ease-in-out infinite',
                'marquee':     'marquee 25s linear infinite',
            },
            keyframes: {
                fadeIn:     { from: { opacity: '0' }, to: { opacity: '1' } },
                slideUp:    { from: { opacity: '0', transform: 'translateY(32px)' }, to: { opacity: '1', transform: 'translateY(0)' } },
                slideRight: { from: { opacity: '0', transform: 'translateX(-24px)' }, to: { opacity: '1', transform: 'translateX(0)' } },
                pulseRed:   { '0%,100%': { boxShadow: '0 0 0 0 rgba(192,57,43,0.4)' }, '50%': { boxShadow: '0 0 0 10px rgba(192,57,43,0)' } },
                marquee:    { '0%': { transform: 'translateX(0)' }, '100%': { transform: 'translateX(-50%)' } },
            },
        },
    },
    plugins: [forms],
};