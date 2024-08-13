document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.nav-link[data-bs-toggle="pill"]');

    let currentPage = 1;
    let currentVacancyId = tabButtons[0]?.getAttribute('data-vacancy-slug'); // Set initial vacancyId based on the first tab

    // Fetch and populate applications for the initially active tab
    if (currentVacancyId) {
        fetchApplications(currentVacancyId, currentPage);
    }

    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', async function (event) {
            const vacancyId = button.getAttribute('data-vacancy-slug');
            currentVacancyId = vacancyId;
            currentPage = 1; // Reset page to 1 for new vacancy

            await fetchApplications(vacancyId, currentPage);
        });
    });

    async function fetchApplications(vacancyId, page = 1) {
        try {
            const response = await fetch(`/api/vacancy/${vacancyId}/employees?page=${page}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const jsonResponse = await response.json();

            const container = document.querySelector(`.container[data-vacancy-slug="${vacancyId}"]`);
            const tableBody = container.querySelector('.table tbody');

            tableBody.innerHTML = '';

            jsonResponse.data.forEach((app, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${(page - 1) * 10 + index + 1}</td>
                    <td>${app.fullName}</td>
                    <td>${app.contactEmail}</td>
                    <td>
                    <a href="/resume/${app.employeeId}?type=${app.cvType}" class="btn btn-outline-light" target="_blank">Show CV</a>
                    </td>
                    <td>${app.appliedAt}</td>
                `;
                tableBody.appendChild(row);
            });

            updatePaginationControls(jsonResponse);

        } catch (error) {
            console.error('Error fetching applications:', error);
        }
    }

    function updatePaginationControls(response) {
        const {current_page, last_page, next_page_url, prev_page_url} = response;

        const paginationControls = document.querySelector(`.container[data-vacancy-slug="${currentVacancyId}"] .pagination-controls`);

        paginationControls.innerHTML = `
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item ${!prev_page_url ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Previous" data-page="${current_page - 1}">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item ${!next_page_url ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Next" data-page="${current_page + 1}">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        `;

        paginationControls.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const page = parseInt(link.getAttribute('data-page'));
                if (page > 0 && page <= last_page) {
                    fetchApplications(currentVacancyId, page);
                }
            });
        });
    }
});
