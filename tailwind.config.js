/** @type {import('tailwindcss').Config} */
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
                }
            }
        },
    },
    darkMode: 'class',
    plugins: [
        require('flowbite/plugin'),
    ],
}
