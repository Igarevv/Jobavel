import {
    fetchData,
    renderPagination,
    renderTable,
    searchData,
} from './dataTables.js';

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('.employers-body');
    const CSRFtoken = document.head.querySelector('[name=csrf-token]').content;
    const paginationContainer = document.querySelector('.pagination-container');
    let searchParams = new URLSearchParams(window.location.search);

    function renderRow(employer, index, data) {
        return `
            <tr class="tbody-content-row bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${index + 1 + (data.current_page - 1) * data.per_page}
                        </th>
                        <td class="px-3 py-4 cursor-pointer" id="id-field-${index}">${employer.idEncrypted}</td>
                        <td class="px-3 py-4">${employer.company}</td>
                        <td class="px-3 py-4">${employer.companyType}</td>
                        <td class="px-3 py-4">${employer.accountEmail}</td>
                        <td class="px-3 py-4">${employer.contactEmail}</td>
                        <td class="px-3 py-4">${employer.createdAt}</td>
                        <td class="px-3 py-4">
                            <button type="button" data-modal-target="#static-modal" data-modal-toggle="#static-modal"
                                    data-employer-id="${employer.id}" data-employer-name="${employer.company}"
                                    class="open-modal-btn unstyled-button font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                View vacancies
                            </button>
                        </td>
                        <td class="px-3 py-4">
                            <form action="" method="POST" class="ban-form">
                                <input type="hidden" name="token" value="${CSRFtoken}" autocomplete="off">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="unstyled-button font-medium text-red-600 dark:text-blue-500 hover:underline">
                                    Ban
                                </button>
                            </form>
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
        const searchBy = document.getElementById('searchBy').value || searchParams.get('searchBy');
        const search = document.getElementById('search-dropdown').value || searchParams.get('search');

        fetchData('/admin/users/employers/table', {
                page,
                sort: searchParams.get('sort') || 'creation-time',
                direction: searchParams.get('direction') || 'desc',
                searchBy: searchBy || null,
                search: search || null,
            }, tableBody,
            data => renderTable(data, tableBody, renderRow),
            data => renderPagination(data, paginationContainer, onPageClick));
    }

    document.getElementById('searchBtn').addEventListener('click', function (e) {
        e.preventDefault();
        const searchBy = document.getElementById('searchBy').value;
        const search = document.getElementById('search-dropdown').value;
        searchData('/admin/users/employers/table', {
            searchBy,
            search,
            page: searchParams.get('page') || 1,
            sort: searchParams.get('sort') || 'creation-time',
        }, tableBody, data => renderTable(data, tableBody, renderRow), data => renderPagination(data, paginationContainer, onPageClick), displayErrors);
    });

    fetchData('/admin/users/employers/table', {
        page: searchParams.get('page') || 1,
        sort: searchParams.get('sort') || 'creation-time',
        direction: searchParams.get('direction') || 'desc',
    }, tableBody, data => renderTable(data, tableBody, renderRow), data => renderPagination(data, paginationContainer, onPageClick));

    document.getElementById('refreshTable').addEventListener('click', (e) => {
        e.preventDefault();

        fetchData('/admin/users/employers/table', {
                page: searchParams.get('page') || 1,
                sort: searchParams.get('sort') || 'creation-time',
                direction: searchParams.get('direction') || 'desc',
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

            // Preserve search parameters if they exist
            const searchBy = document.getElementById('searchBy').value || searchParams.get('searchBy');
            const search = document.getElementById('search-dropdown').value || searchParams.get('search');

            fetchData('/admin/users/employers/table', {
                page: 1,
                sort,
                direction,
                searchBy: searchBy || null,
                search: search || null,
            }, tableBody, data => renderTable(data, tableBody, renderRow), data => renderPagination(data, paginationContainer, onPageClick));
        });
    });
});
