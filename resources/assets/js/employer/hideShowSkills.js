document.addEventListener('DOMContentLoaded', function () {
    const showMoreButtons = document.querySelectorAll('.show-more');

    showMoreButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const cardBody = button.closest('.card-body');

            const hiddenSkillsContainer = cardBody.querySelector('.hidden-skills');
            const hideButton = cardBody.querySelector('.hide-wheel');

            if (hiddenSkillsContainer) {
                hiddenSkillsContainer.classList.remove('d-none');
                button.classList.add('d-none');
                hideButton.classList.remove('d-none');
            }
        });
    });

    const hideButtons = document.querySelectorAll('.hide-wheel');

    hideButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const cardBody = button.closest('.card-body');

            const hiddenSkillsContainer = cardBody.querySelector('.hidden-skills');
            const showMoreButton = cardBody.querySelector('.show-more');

            if (hiddenSkillsContainer) {
                hiddenSkillsContainer.classList.add('d-none');
                button.classList.add('d-none');
                showMoreButton.classList.remove('d-none');
            }
        });
    });
});
