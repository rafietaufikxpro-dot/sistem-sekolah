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
                sans: ['Inter', 'ui-sans-serif', 'system-ui', ...defaultTheme.fontFamily.sans],
                serif: ['"Source Serif 4"', 'Georgia', 'serif', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                ink:   { 900:'#1B2430', 700:'#3A4756', 500:'#6B7686', 300:'#AEB6C2', 100:'#E6E9ED', 50:'#F4F5F7' },
                navy:  { 900:'#152238', 700:'#22375C', 600:'#2C4573', 100:'#E2E8F5' },
                amber: { 600:'#B8790A', 100:'#FBEBCC' },
                green: { 700:'#276749', 100:'#DFF3E6' },
                red:   { 700:'#B3261E', 100:'#FBE3E1' },
                paper: '#FBFAF7',
            },
        },
    },

    plugins: [forms],
};

