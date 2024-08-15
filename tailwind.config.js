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
                red: '#f9322c',
            }
        },
    },
    darkMode: 'class',
    plugins: [
        require('flowbite/plugin')
    ],
}
