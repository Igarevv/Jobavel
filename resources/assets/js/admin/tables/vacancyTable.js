import { fetchData, renderPagination, renderTable } from './dataTables.js';

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('.vacancies-body');
    const paginationContainer = document.querySelector('.pagination-container');
    let searchParams = new URLSearchParams(window.location.search);

    function renderRow(vacancy, index, data) {
        const linkToVacancy = vacancy.isTrashed ? '/admin/vacancy/' + vacancy.slug + '/trashed' : '/vacancies/' + vacancy.slug;
        return `
            <tr class="tbody-content-row bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${index + 1 + (data.current_page - 1) * data.per_page}
                        </th>
                        <td class="px-3 py-4">
                            <a href="${linkToVacancy}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">${vacancy.title}</a>
                            ${vacancy.isTrashed ? `<span class="text-red-500 text-sm font-bold">(Trashed)</span>` : ''}
                        </td>
                        <td class="px-3 py-4">${vacancy.employment}</td>
                        <td class="px-3 py-4">${vacancy.responses}</td>
                        <td class="px-3 py-4">
                            <button type="button" data-modal-target="#static-modal" data-modal-toggle="#static-modal"
                                    data-vacancy-slug="${vacancy.slug}" data-vacancy-title="${vacancy.title}"
                                    class="open-modal-btn unstyled-button font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                View
                            </button>
                        </td>
                        <td class="px-3 py-4">${vacancy.createdAt}</td>
                        <td class="px-3 py-4">${vacancy.publishedAt}</td>
                    </tr>
        `;
    }

    function displayErrors(errors) {
        const errorMessagesSpan = document.getElementById('search-validation-error');
        errorMessagesSpan.innerText = '';

        if (errors.searchBy && errors.searchBy.length > 0) {
            errorMessagesSpan.innerText += errors.searchBy.join(', ');
            return;
        }

        if (errors.search && errors.search.length > 0) {
            errorMessagesSpan.innerText += errors.search.join(', ');
        }
    }

    function onPageClick(page) {
        const searchBy = document.getElementById('searchBy').value || searchParams.get('searchBy');
        const search = document.getElementById('search-dropdown').value || searchParams.get('search');

        fetchData('/admin/vacancies/table', {
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

        fetchData('/admin/vacancies/table', {
                searchBy,
                search,
                page: searchParams.get('page') || 1,
                sort: searchParams.get('sort') || 'creation-time',
                direction: searchParams.get('direction') || 'desc',
            }, tableBody,
            data => renderTable(data, tableBody, renderRow),
            data => renderPagination(data, paginationContainer, onPageClick),
            displayErrors,
        );
    });

    fetchData('/admin/vacancies/table', {
        page: searchParams.get('page') || 1,
        sort: searchParams.get('sort') || 'creation-time',
        direction: searchParams.get('direction') || 'desc',
    }, tableBody, data => renderTable(data, tableBody, renderRow), data => renderPagination(data, paginationContainer, onPageClick));

    document.getElementById('refreshTable').addEventListener('click', (e) => {
        e.preventDefault();

        fetchData('/admin/vacancies/table', {
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

            const searchBy = document.getElementById('searchBy').value || searchParams.get('searchBy');
            const search = document.getElementById('search-dropdown').value || searchParams.get('search');

            fetchData('/admin/vacancies/table', {
                page: 1,
                sort,
                direction,
                searchBy: searchBy || null,
                search: search || null,
            }, tableBody, data => renderTable(data, tableBody, renderRow), data => renderPagination(data, paginationContainer, onPageClick));
        });
    });
});
