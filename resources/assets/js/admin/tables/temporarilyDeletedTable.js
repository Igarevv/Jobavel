import {fetchData, renderPagination, renderTable, searchData} from "./dataTables.js";

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('.temporarily-deleted');
    const CSRFtoken = document.head.querySelector("[name=csrf-token]").content;
    const paginationContainer = document.querySelector('.pagination-container');
    let searchParams = new URLSearchParams(window.location.search);

    function renderRow(user, index, data) {
        return `
            <tr class="tbody-contexnt-row bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${index + 1 + (data.current_page - 1) * data.per_page}
                </th>
                <td class="px-3 py-4">${user.idEncrypted}</td>
                <td class="px-3 py-4">${user.email}</td>
                <td class="px-3 py-4">${user.createdAt}</td>
                <td class="px-3 py-4">${user.deletedAt}</td>
                <td class="px-3 py-4">
                    <button type="button" data-modal-target="#popup-modal" data-modal-toggle="#popup-modal"
                            data-user-id="${user.id}"
                            class="restore-btn unstyled-button font-medium text-green-400 dark:text-white hover:underline">
                        Restore
                    </button>
                </td>
            </tr>
        `;
    }

    function displayErrors(errors) {
        const errorMessagesSpan = document.getElementById('search-validation-error');
        errorMessagesSpan.innerText = '';

        if (errors.searchBy) {
            errorMessagesSpan.innerText += errors.searchBy;
            return;
        }

        if (errors.search) {
            errorMessagesSpan.innerText += errors.search;
        }
    }

    function onPageClick(page) {
        fetchData('/admin/users/temporarily-deleted/table', {
                page, sort: searchParams.get('sort') || 'creation-time', direction: searchParams.get('direction') || 'desc'
            },
            tableBody,
            data => renderTable(data, tableBody, renderRow),
            data => renderPagination(data, paginationContainer, onPageClick)
        );
    }

    document.getElementById('refreshTable').addEventListener('click', (e) => {
        e.preventDefault();

        fetchData('/admin/users/temporarily-deleted/table', {
                page: searchParams.get('page') || 1,
                sort: searchParams.get('sort') || 'creation-time',
                direction: searchParams.get('direction') || 'desc'
            }, tableBody,
            data => renderTable(data, tableBody, renderRow),
            data => renderPagination(data, paginationContainer, onPageClick));

        let currentTime = new Date();

        document.getElementById('refresh-span').innerText = 'Refreshed ' + currentTime.getHours() + ':' + currentTime.getMinutes();
    });

    document.getElementById('searchBtn').addEventListener('click', function (e) {
        e.preventDefault();
        const searchBy = document.getElementById('searchBy').value;
        const search = document.getElementById('search-dropdown').value;
        searchData('/admin/users/temporarily-deleted/search', {
                page: 1,
                searchBy,
                search
            }, tableBody,
            data => renderTable(data, tableBody, renderRow),
            data => renderPagination(data, paginationContainer, onPageClick), displayErrors);
    });

    fetchData('/admin/users/temporarily-deleted/table', {
            page: searchParams.get('page') || 1,
            sort: searchParams.get('sort') || 'creation-time',
            direction: searchParams.get('direction') || 'desc'
        }, tableBody,
        data => renderTable(data, tableBody, renderRow),
        data => renderPagination(data, paginationContainer, onPageClick));

    document.querySelectorAll('.sort-link').forEach(link => {
        link.addEventListener('click', function () {
            const sort = this.dataset.sort;
            let direction = this.dataset.direction || 'desc';
            direction = direction === 'asc' ? 'desc' : 'asc';
            this.dataset.direction = direction;

            const ascIcon = this.querySelector('#asc-icon');
            const descIcon = this.querySelector('#desc-icon');

            if (direction === 'asc') {
                ascIcon.classList.add('text-red-100', 'dark:text-white');
                ascIcon.classList.remove('dark:text-black');
                descIcon.classList.remove('text-red-100', 'dark:text-white');
                descIcon.classList.add('dark:text-black');
            } else {
                ascIcon.classList.remove('text-red-100', 'dark:text-white');
                ascIcon.classList.add('dark:text-black');
                descIcon.classList.remove('dark:text-black');
                descIcon.classList.add('text-red-100', 'dark:text-white');
            }

            fetchData('/admin/users/temporarily-deleted/table', {
                    page: 1,
                    sort,
                    direction
                }, tableBody,
                data => renderTable(data, tableBody, renderRow),
                data => renderPagination(data, paginationContainer, onPageClick));
        });
    });

    const form = document.getElementById('restoreForm');
});

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('restore-btn')) {
        const button = e.target;
        const form = document.getElementById('restoreForm');
        const modalElement = document.getElementById('popup-modal');
        const modal = new Modal(modalElement);

        modal.show();

        const closeModalBtn = modalElement.querySelectorAll('.hide-modal-btn');
        closeModalBtn.forEach(closeBtn => {
            closeBtn.addEventListener('click', () => {
                modal.hide();
            });
        });

        const userId = button.getAttribute('data-user-id');
        const action = form.getAttribute('action').replace(':id', userId);
        form.setAttribute('action', action);
    }
});
