import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from '@rollup/plugin-inject';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/assets/css/app.css',
                'resources/assets/css/admin.css',
                'resources/assets/js/admin.js',
                'resources/assets/js/app.js',
                'resources/assets/js/employer/changeLogo.js',
                'resources/assets/js/employer/filter.js',
                'resources/assets/js/employer/hideShowSkills.js',
                'resources/assets/js/employer/verificationCode.js',
                'resources/assets/js/addNewField.js',
                'resources/assets/js/viewSkills.js',
                'resources/assets/js/employee/employeePersonalInfo.js',
                'resources/assets/js/employer/getEmployeesForVacancy.js',
                'resources/assets/js/admin/rolePermissions.js'
            ],
            refresh: true,
        }),
        inject({
            jQuery: "jquery",
            "window.jQuery": "jquery",
            $: "jquery"
        })
    ],
});
