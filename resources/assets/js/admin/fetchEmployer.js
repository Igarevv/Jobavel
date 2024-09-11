import axios from "axios";

document.addEventListener('click', async function (e) {
    if (e.target.classList.contains('open-modal-btn')) {
        const vacancySlug = e.target.getAttribute('data-vacancy-slug');
        const vacancyTitle = e.target.getAttribute('data-vacancy-title');

        const modalElement = document.getElementById('static-modal');
        const modal = new Modal(modalElement);
        modal.show();

        const loadingOverlay = document.getElementById('modal-loading-overlay');
        loadingOverlay.classList.add('show');

        const closeModalBtn = modalElement.querySelectorAll('.hide-modal-btn');

        closeModalBtn.forEach(button => {
            button.addEventListener('click', () => {
                modal.hide();
            });
        });

        try {
            const response = await axios.get(`/admin/vacancies/${vacancySlug}/employer`);

            const employer = response.data;
            const modalHeader = document.getElementById('modal-header').innerText = 'Vacancy - ' + vacancyTitle;
            const company = document.getElementById('company').innerText = employer.company;
            const type = document.getElementById('type').innerText = employer.type + ' company';
            const contactEmail = document.getElementById('contact-email').innerText = employer.contactEmail;
            const createdAt = document.getElementById('created-at').innerText = employer.createdAt;
            const id = document.getElementById('employer-id').innerText = employer.id;
            const logo = document.getElementById('employer-logo').src = employer.logo;
        } catch (error) {
            console.error('Error fetching vacancies:', error);
        } finally {
            loadingOverlay.classList.remove('show')
        }
    }
});
