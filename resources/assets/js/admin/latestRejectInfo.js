const btn = document.getElementById('show-latest-reject-modal-btn');

btn.addEventListener('click', async (e) => {
    const response = await fetch(`/moderation/vacancy/${e.target.getAttribute('data-vacancy-slug')}/previous-reject`);

    const data = await response.json();

    if (Object.keys(data).length === 0) {
        document.getElementById('latest-reject-content').classList.remove('d-block');
        document.getElementById('latest-reject-content').classList.add('d-none');

        document.getElementById('not-found-reject-message').classList.remove('d-none');
        document.getElementById('not-found-reject-message').classList.add('d-block');

        document.getElementById('reject-message').innerText = 'Latest reject info not found';
    } else {
        document.getElementById('reject-reason').innerText = data.reason;
        document.getElementById('reject-description').innerText = data.description;
        document.getElementById('reject-performed-time').innerText = data.performedAt;

        if (data.comment !== null) {
            document.getElementById('optional-block').classList.remove('d-none');
            document.getElementById('optional-block').classList.add('d-block');
            document.getElementById('comment').innerText = data.comment;
        }
    }
});
