import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from '@rollup/plugin-inject';

export default defineConfig({
    server: {
        host: true,
        https: false,
        strictPort: true,
        port: 5173,
        hmr: {
            host: 'localhost', //localhost | 192.168.1.x
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
                'resources/assets/js/admin/rolesPermissions.js',
                'resources/assets/js/admin/fetchEmployerVacancies.js',
                'resources/assets/js/admin/tables/dataTables.js',
                'resources/assets/js/admin/tables/employerTable.js',
                'resources/assets/js/admin/tables/employeeTable.js',
                'resources/assets/js/admin/tables/temporarilyDeletedTable.js',
                'resources/assets/js/admin/tables/unverifiedTable.js',
                'resources/assets/js/admin/tables/adminsTable.js',
                'resources/assets/js/admin/tables/vacancyTable.js',
                'resources/assets/js/admin/fetchEmployer.js'
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
