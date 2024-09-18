import axios from 'axios';

document.addEventListener('click', async function (e) {
    if (e.target.classList.contains('open-delete-modal-btn')) {
        const employerId = e.target.getAttribute('data-employer-id');
        document.querySelector('.employer-name').innerText = e.target.getAttribute('data-employer-name');

        const modalElement = document.getElementById('ban-employer-modal');
        const modal = new Modal(modalElement);
        modal.show();

        const closeModalBtn = modalElement.querySelector('.hide-modal-btn');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', () => {
                modal.hide();
            });
        }

        const form = document.getElementById('ban-form');
        const action = form.getAttribute('action').replace(':id', employerId);
        form.setAttribute('action', action);
    }

    if (e.target.classList.contains('open-modal-btn')) {
        const employerId = e.target.getAttribute('data-employer-id');
        const employerName = e.target.getAttribute('data-employer-name');
        const token = window.Laravel.token;

        const modalElement = document.getElementById('static-modal');
        const modal = new Modal(modalElement);
        modal.show();

        const loadingOverlay = document.getElementById('modal-loading-overlay');
        loadingOverlay.classList.add('show');

        const closeModalBtn = modalElement.querySelector('.hide-modal-btn');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', () => {
                modal.hide();
            });
        }

        try {
            const response = await axios.get(`/api/admin/employers/${employerId}/vacancies`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            const vacancies = response.data;
            const body = document.querySelector('.table-body');

            body.innerHTML = '';

            document.querySelectorAll('.employer-name').forEach(span => {
                span.innerText = employerName;
            });

            if (vacancies.data.length === 0) {
                const tr = document.createElement('tr');
                const td = document.createElement('td');
                td.className = 'text-center py-6';
                td.colSpan = 8;

                const span = document.createElement('span');
                span.className = 'text-xl text-gray-500 dark:text-gray-400';
                span.textContent = 'This employer has no vacancies';

                td.appendChild(span);
                tr.appendChild(td);
                body.appendChild(tr);
            } else {
                let i = 0;
                vacancies.data.forEach(vacancy => {
                    const tr = document.createElement('tr');
                    tr.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700';

                    const th = document.createElement('th');
                    th.scope = 'row';
                    th.className = 'px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white';
                    th.textContent = `${++i}`;

                    tr.appendChild(th);

                    const cells = [
                        {
                            content: vacancy.title,
                            link: `/vacancies/${vacancy.slug}`
                        },
                        vacancy.location,
                        vacancy.employment,
                        vacancy.response,
                        vacancy.publishedAt,
                        vacancy.createdAt,
                    ];

                    cells.forEach((cell, index) => {
                        const td = document.createElement('td');
                        td.className = 'px-3 py-4';

                        if (index === 0 && cell.link) {
                            const a = document.createElement('a');
                            a.href = cell.link;
                            a.className = 'font-medium text-blue-600 dark:text-blue-500 hover:underline';
                            a.textContent = cell.content;
                            td.appendChild(a);
                        } else {
                            td.textContent = cell;
                        }

                        tr.appendChild(td);
                    });

                    body.appendChild(tr);
                });
            }
        } catch (error) {
            console.error('Error fetching vacancies:', error);
        } finally {
            loadingOverlay.classList.remove('show')
        }
    }
});
