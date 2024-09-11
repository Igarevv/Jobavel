import {fetchData, renderPagination, renderTable} from './dataTables.js';

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('.admins-body');
    const CSRFtoken = document.head.querySelector("[name=csrf-token]").content;
    const paginationContainer = document.querySelector('.pagination-container');
    let searchParams = new URLSearchParams(window.location.search);

    function renderRow(admin, index, data) {
        return `
            <tr class="tbody-contexnt-row bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${index + 1 + (data.current_page - 1) * data.per_page}
                </th>
                <td class="px-3 py-4">${admin.idEncrypted}</td>
                <td class="px-3 py-4">${admin.name}</td>
                <td class="px-3 py-4">${admin.email}</td>
                <td class="px-3 py-4">${admin.status}</td>
                <td class="px-3 py-4">${admin.createdAt}</td>
            </tr>
        `;
    }

    function onPageClick(page) {
        fetchData('/admin/users/admins/table', {
                page, sort: searchParams.get('sort') || 'creation-time', direction: searchParams.get('direction') || 'desc'
            },
            tableBody,
            data => renderTable(data, tableBody, renderRow),
            data => renderPagination(data, paginationContainer, onPageClick)
        );
    }

    fetchData('/admin/users/admins/table', {
            page: searchParams.get('page') || 1,
            sort: searchParams.get('sort') || 'creation-time',
            direction: searchParams.get('direction') || 'desc'
        }, tableBody,
        data => renderTable(data, tableBody, renderRow),
        data => renderPagination(data, paginationContainer, onPageClick));

    document.getElementById('refreshTable').addEventListener('click', (e) => {
        e.preventDefault();

        fetchData('/admin/users/admins/table', {
                page: searchParams.get('page') || 1,
                sort: searchParams.get('sort') || 'creation-time',
                direction: searchParams.get('direction') || 'desc'
            }, tableBody,
            data => renderTable(data, tableBody, renderRow),
            data => renderPagination(data, paginationContainer, onPageClick));

        let currentTime = new Date();

        document.getElementById('refresh-span').innerText = 'Refreshed ' + currentTime.getHours() + ':' + currentTime.getMinutes();
    });

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

            fetchData('/admin/users/admins/table', {
                page: 1,
                sort,
                direction
            }, tableBody, data => renderTable(data, tableBody, renderRow), data => renderPagination(data, paginationContainer, onPageClick));
        });
    });
});
