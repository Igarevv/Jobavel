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

    const result = await sendUpdateRequest(resetForm);

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

const updateForm = document.getElementById('update-info-form');

updateForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const result = await sendUpdateRequest(updateForm);

    if (result.message) {
        document.getElementById('message').innerText = result.message;
    }
})


function sendUpdateRequest(form) {
    const formData = new FormData(updateForm);
    const response = fetch(updateForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })

    return response.json();
}
