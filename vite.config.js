import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from '@rollup/plugin-inject';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/app.css',
                'resources/assets/js/app.js',
                'resources/assets/js/employer/changeLogo.js',
                'resources/assets/js/employer/filter.js',
                'resources/assets/js/employer/hideShowSkills.js',
                'resources/assets/js/employer/verificationCode.js',
                'resources/assets/js/addNewField.js',
                'resources/assets/js/viewSkills.js',
                'resources/assets/js/employee/employeePersonalInfo.js',
                'resources/assets/js/employer/getEmployeesForVacancy.js'
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
