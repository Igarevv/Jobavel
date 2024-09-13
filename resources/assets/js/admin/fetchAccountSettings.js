document.querySelectorAll('.open-settings-modal').forEach(button => {
    button.addEventListener('click', async (event) => {
        const response = await fetch(`/admin/account/settings`);
        const user = await response.json();

        const status = document.getElementById('settings-status');
        status.innerText = user.status.name;
        status.style.backgroundColor = user.status.color;
        document.getElementById('settings-email').value = user.email;
        document.getElementById('settings-created').innerText = user.createdAt;
        document.getElementById('settings-first-name').value = user.firstName;
        document.getElementById('settings-last-name').value = user.lastName;
        document.getElementById('last-reset-at').innerText = user.lastPasswordRest;
        document.getElementById('settings-modal').classList.remove('hidden');
    });
});

const resetForm = document.getElementById('reset-form');
resetForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(resetForm);
    const response = await fetch(resetForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
    const result = await response.json();

    if (result.errors) {
        Object.keys(result.errors).forEach(key => {
            const messages = result.errors[key];
            console.log(messages)
            messages.forEach(message => {
                document.getElementById('form-errors-span').innerText = message;
            });
        })
    }

    if (result.redirect) {
        await fetch(result.redirect, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        window.location.href = result.redirect;
    }
});
