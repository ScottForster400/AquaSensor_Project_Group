
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

const plugin = require("tailwindcss/plugin")

const Myclass = plugin(function({addUtilities}){
    addUtilities({
        ".my-rotate-y-180":{
            transform:"rotateX(-180deg)",
        },
        ".preserve-3d":{
            transformStyle: "preserve-3d",
        },
        ".perspective":{
            perspective:"1000px",
        },
        ".backface-hidden":{
            backfaceVisibility:"hidden",
        }

    })
})

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin'),
        Myclass,
    ],

};

