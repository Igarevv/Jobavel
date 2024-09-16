// dataTableUtils.js

import axios from 'axios';

export function updateQueryParams(params) {
    const searchParams = new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search).entries()), ...params});
    window.history.replaceState(null, '', `${window.location.pathname}?${searchParams.toString()}`);
    return searchParams;
}

export function fetchData(url, params, tableBody, renderTable, renderPagination) {
    axios.get(url, {params})
        .then(response => {
            const {data} = response;
            tableBody.innerHTML = '';
            document.getElementById('foundRecords').innerText = data.total;
            renderTable(data);
            renderPagination(data);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

export function searchData(url, params, tableBody, renderTable, renderPagination, displayErrors) {
    axios.get(url, {params})
        .then(response => {
            const {data} = response;
            document.getElementById('search-validation-error').innerHTML = '';
            tableBody.innerHTML = '';
            document.getElementById('foundRecords').innerText = data.total;
            renderTable(data);
            renderPagination(data);
        })
        .catch(error => {
            if (error.response && error.response.data.errors) {
                displayErrors(error.response.data.errors);
            }
        });
}

export function renderPagination(data, paginationContainer, onPageClick) {
    const {current_page, last_page, total, per_page} = data;

    paginationContainer.innerHTML = `
        <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6">
          <div class="flex flex-1 justify-between sm:hidden">
            ${current_page > 1 ? `<button data-page="${current_page - 1}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</button>` : ''}
            ${current_page < last_page ? `<button data-page="${current_page + 1}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</button>` : ''}
          </div>
          <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700 dark:text-white">
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
                      <button data-page="${page}" class="relative inline-flex items-center ${page === current_page ? 'bg-red-600 text-white z-10 ' : 'dark:bg-white text-gray-900 ring-1 ring-inset dark:hover:bg-gray-500 dark:hover:ring-gray-500 ring-gray-300 hover:bg-gray-50'} px-4 py-2 text-sm font-semibold focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
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
        button.addEventListener('click', () => onPageClick(button.getAttribute('data-page')));
    });
}

export function renderTable(data, tableBody, renderRow) {
    if (data.data.length > 0) {
        data.data.forEach((item, index) => {
            const rowHtml = renderRow(item, index, data);
            tableBody.insertAdjacentHTML('beforeend', rowHtml);
            copyId(index, item.id);
        });
    } else {
        tableBody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-6">
                    <span class="text-xl text-gray-500 dark:text-gray-400">
                        No records found
                    </span>
                </td>
            </tr>
        `;
    }
}

function copyId(rowIndex, itemId) {
    const idField = document.getElementById(`id-field-${rowIndex}`);

    if (idField) {
        idField.addEventListener('click', () => {
            navigator.clipboard.writeText(itemId).then(() => {
                const span = document.createElement('span');
                span.classList.add('text-green-500', 'text-sm', 'ps-2');
                span.textContent = 'Copied!';

                idField.appendChild(span);

                setTimeout(() => {
                    span.remove();
                }, 2000);
            });
        });
    }
}
