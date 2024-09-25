import { renderPagination } from './tables/dataTables.js';
import axios from 'axios';

document.addEventListener('click', async function (e) {
    if (e.target.classList.contains('open-actions-modal-btn')) {
        const id = e.target.getAttribute('data-id');
        document.querySelectorAll('.admin-name').forEach(span => span.innerText = e.target.getAttribute('data-name'));

        const modalElement = document.getElementById('actions-modal');
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

        const fetchActions = async (page = 1) => {
            try {
                const response = await axios.get(`/admin/users/admins/${id}/actions?page=${page}`);

                const actions = response.data;
                const body = document.querySelector('.table-body');
                const paginationContainer = document.querySelector('.pagination-container-modal');

                body.innerHTML = '';

                if (actions.data.length === 0) {
                    const tr = document.createElement('tr');
                    const td = document.createElement('td');
                    td.className = 'text-center py-6';
                    td.colSpan = 8;

                    const span = document.createElement('span');
                    span.className = 'text-xl text-gray-500 dark:text-gray-400';
                    span.textContent = 'This admin has no actions';

                    td.appendChild(span);
                    tr.appendChild(td);
                    body.appendChild(tr);
                } else {
                    let i = (actions.current_page - 1) * actions.per_page;
                    actions.data.forEach(action => {
                        const tr = document.createElement('tr');
                        tr.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700';

                        const th = document.createElement('th');
                        th.scope = 'row';
                        th.className = 'px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white';
                        th.textContent = `${++i}`;

                        tr.appendChild(th);

                        const cells = [
                            action.entityName,
                            action.entityId,
                            action.name,
                            action.reasonType,
                            action.performedAt,
                        ];

                        cells.forEach((cell, index) => {
                            const td = document.createElement('td');
                            td.className = 'px-3 py-4';
                            td.textContent = cell;
                            tr.appendChild(td);
                        });

                        body.appendChild(tr);
                    });

                    renderPagination(actions, paginationContainer, (page) => fetchActions(page));
                }
            } catch (error) {
                console.error('Error fetching actions:', error);
            } finally {
                loadingOverlay.classList.remove('show');
            }
        };

        await fetchActions(1);
    }
});
