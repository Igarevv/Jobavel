import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const roles = document.querySelectorAll('.custom-radio');

    roles.forEach(roleRadio => {
        roleRadio.addEventListener('click', async () => {
            const id = roleRadio.getAttribute('data-role-id');

            const response = await axios.get(`/api/admin/roles/${id}/permissions`, {
                headers: {
                    'Authorization': `Bearer ${window.Laravel.token}`
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

    const searchInput  = document.getElementById('user-admin');

    let debounceTimer;

    function handleInput(event) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout((e) => {
            const query = searchInput.value.trim();

            if (query.length >= 2) {
                axios.get(`/api/admin/person/${query}/permissions`, {
                    headers: {
                        'Authorization': `Bearer ${window.Laravel.token}`
                    }
                })
                    .then(response => {
                        if (response.data.status === 404) {
                            document.getElementById('live-search-error').innerText = 'Admin not found.';
                            return;
                        }

                        const permissions = response.data.permissions;

                        if (permissions.length !== 0) {
                            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                                checkbox.checked = false;
                            });

                            permissions.forEach(permission => {
                                const checkbox = document.querySelector(`#permission-admin-${permission.id}`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }
                            });

                            document.getElementById('live-search-error').innerText = '';
                        } else {
                            document.querySelectorAll('.admin-permissions').forEach(checkbox => {
                                checkbox.checked = false;
                            });
                            document.getElementById('live-search-error').innerText = 'Current admin has no permissions.';
                        }
                    });
            }
        }, 300);
    }

    searchInput.addEventListener('input', handleInput);
});
