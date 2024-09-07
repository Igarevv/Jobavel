import axios from "axios";

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('.employers-body');
    const CSRFtoken = document.head.querySelector("[name=csrf-token]").content;
    const paginationContainer = document.querySelector('.pagination-container');

    let searchParams = new URLSearchParams(window.location.search);

    function updateQueryParams(params) {
        searchParams = new URLSearchParams({...Object.fromEntries(searchParams.entries()), ...params});
        window.history.replaceState(null, '', `${window.location.pathname}?${searchParams.toString()}`);
    }

    function fetchEmployers(page = 1, sort = 'creation-time', direction = 'desc', searchBy = '', search = '') {
        updateQueryParams({page, sort, direction, searchBy, search});

        axios.get('/admin/users/employers/table', {
            params: {page, sort, direction}
        })
            .then(response => {
                const {data} = response;

                tableBody.innerHTML = '';

                document.getElementById('foundEmployers').innerText = data.total;

                renderTable(data);
                renderPagination(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function searchForEmployers(page = 1, searchBy, search) {
        updateQueryParams({page, searchBy, search});

        axios.get('/admin/users/employers/search', {
            params: {page, searchBy, search}
        }).then(response => {
            const {data} = response;

            document.getElementById('search-validation-error').innerHTML = '';

            tableBody.innerHTML = '';

            document.getElementById('foundEmployers').innerText = data.total;

            renderTable(data);
            renderPagination(data);
        }).catch(error => {
            if (error.response && error.response.data.errors) {
                displayErrors(error.response.data.errors);
            }
        })
    }

    document.getElementById('searchBtn').addEventListener('click', function (e) {
        e.preventDefault();

        const searchBy = document.getElementById('searchBy').value;
        const search = document.getElementById('search-dropdown').value;

        searchForEmployers(1, searchBy, search);
    });

    fetchEmployers(searchParams.get('page') || 1, searchParams.get('sort') || 'creation-time', searchParams.get('direction') || 'desc');

    document.querySelectorAll('.sort-link').forEach(link => {
        link.addEventListener('click', function () {
            const sort = this.dataset.sort;
            const direction = this.dataset.direction;
            fetchEmployers(1, sort, direction, searchParams.get('searchBy'), searchParams.get('search'));
        });
    });

    function renderTable(data) {
        if (data.data.length > 0) {
            data.data.forEach((employer, index) => {
                tableBody.innerHTML += `
                    <tr class="tbody-content-row bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${index + 1 + (data.current_page - 1) * data.per_page}
                        </th>
                        <td class="px-3 py-4">${employer.idEncrypted}</td>
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
            });
        } else {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-6">
                        <span class="text-xl text-gray-500 dark:text-gray-400">
                            Employers not found
                        </span>
                    </td>
                </tr>
            `;
        }
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

    function renderPagination(data) {
        const {current_page, last_page, total, per_page} = data;

        paginationContainer.innerHTML = `
        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
          <div class="flex flex-1 justify-between sm:hidden">
            ${current_page > 1 ? `<button data-page="${current_page - 1}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</button>` : ''}
            ${current_page < last_page ? `<button data-page="${current_page + 1}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</button>` : ''}
          </div>
          <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">${(current_page - 1) * per_page + 1}</span>
                to
                <span class="font-medium">${Math.min(current_page * per_page, total)}</span>
                of
                <span class="font-medium">${total}</span>
                results
              </p>
            </div>
            <div>
              <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                ${current_page > 1 ? `
                  <button data-page="${current_page - 1}" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Previous</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                    </svg>
                  </button>
                ` : ''}
                ${Array.from({length: last_page}, (_, i) => i + 1).map(page => {
            return `
                      <button data-page="${page}" class="relative inline-flex items-center ${page === current_page ? 'bg-red-600 text-white z-10' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'} px-4 py-2 text-sm font-semibold focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        ${page}
                      </button>
                    `;
        }).join('')}
                ${current_page < last_page ? `
                  <button data-page="${current_page + 1}" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                    <span class="sr-only">Next</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M7.23 5.23a.75.75 0 01.02 1.06L11.168 10 7.23 13.71a.75.75 0 01-1.04-1.08l4.5-4.25a.75.75 0 010-1.08l-4.5-4.25a.75.75 0 01-1.06.02z" clip-rule="evenodd" />
                    </svg>
                  </button>
                ` : ''}
              </nav>
            </div>
          </div>
        </div>
        `;

        paginationContainer.querySelectorAll('button[data-page]').forEach(button => {
            button.addEventListener('click', function () {
                const page = this.getAttribute('data-page');
                fetchEmployers(page, searchParams.get('sort'), searchParams.get('direction'), searchParams.get('searchBy'), searchParams.get('search'));
            });
        });
    }
});
