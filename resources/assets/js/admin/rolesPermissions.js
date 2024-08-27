document.addEventListener('DOMContentLoaded', () => {
    const roles = document.querySelectorAll('.custom-radio');

    roles.forEach(roleRadio => {
        roleRadio.addEventListener('click', async () => {
            const id = roleRadio.getAttribute('data-role-id');

            const response = await fetch(`/api/admin/roles/${id}/permissions`);

            const data = await response.json();

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
