const btn = document.getElementById('open-button-trashed-modal');

btn.addEventListener('click', async (e) => {
    const response = await fetch(`/moderation/vacancy/${e.target.getAttribute('data-vacancy-slug')}/trash-info`);

    const data = await response.json();

    if (Object.keys(data).length === 0) {
        document.getElementById('trash-info-content').classList.remove('d-block');
        document.getElementById('trash-info-content').classList.add('d-none');

        document.getElementById('not-found-trash-message').classList.remove('d-none');
        document.getElementById('not-found-trash-message').classList.add('d-block');

        document.getElementById('trash-message').innerText = 'Latest reject info not found';
    } else {
        document.getElementById('trash-reason').innerText = data.reason;
        document.getElementById('trash-description').innerText = data.description;
        document.getElementById('trash-performed-time').innerText = data.performedAt;

        if (data.comment !== null) {
            document.getElementById('optional-block').classList.remove('d-none');
            document.getElementById('optional-block').classList.add('d-block');
            document.getElementById('trash-comment').innerText = data.comment;
        }
    }
});
