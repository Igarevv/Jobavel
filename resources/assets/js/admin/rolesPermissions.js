import axios from "axios";

document.addEventListener('DOMContentLoaded', () => {
    const roles = document.querySelectorAll('.custom-radio');

    const token = window.Laravel.token;

    roles.forEach(roleRadio => {
        roleRadio.addEventListener('click', async () => {
            const id = roleRadio.getAttribute('data-role-id');

            const response = await axios.get(`/api/admin/roles/${id}/permissions`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            const data = await response.data;

            const checkboxes = document.querySelectorAll('#permissionsList input[type="checkbox"]');

            checkboxes.forEach(checkbox => checkbox.checked = false);

            data.permissions.forEach(permission => {
                const checkbox = document.querySelector(`#permission-${permission.id}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        });
    });

    const firstRole = document.querySelector('.custom-radio:checked');
    if (firstRole) {
        firstRole.click();
    }
});
