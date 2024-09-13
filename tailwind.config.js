/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                ...colors,
                red: {
                    '100': '#f9322c',
                    '200': '#f9322c',
                    '300': '#f9322c',
                    '400': '#f9322c',
                    '500': '#f9322c',
                    '600': '#f9322c',
                    '700': '#f9322c',
                    '800': '#f9322c',
                    '900': '#f9322c',
                },
                yellow: {
                    '100': '#f18f10'
                }
            }
        },
    },
    darkMode: 'class',
    plugins: [
        require('flowbite/plugin'),
    ],
}
