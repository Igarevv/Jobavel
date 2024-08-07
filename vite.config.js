import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/app.css',
                'resources/assets/js/app.js',
                'resources/assets/js/employer/**',
                'resources/assets/js/addNewField.js',
                'resources/assets/js/viewSkills.js',
                'resources/assets/js/employee/**',
            ],
            refresh: true,
        }),
    ],
});
