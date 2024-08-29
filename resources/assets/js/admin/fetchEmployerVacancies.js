document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.open-modal-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const employerId = button.getAttribute('data-employer-id');

            const response = await fetch(`/api/admin/employers/${employerId}/vacancies`);

            const vacancies = await response.json();

            document.querySelectorAll('.employer-name')
                .forEach(span => span.innerText = button.getAttribute('data-employer-name'));

            const body = document.querySelector('.table-body');
            body.innerHTML = '';

            let i = 0;

            if (vacancies.data.length === 0) {
                const tr = document.createElement('tr');

                const td = document.createElement('td');
                td.className = 'text-center py-6';
                td.colSpan = 8;

                const span = document.createElement('span');
                span.className = 'text-xl text-gray-500 dark:text-gray-400';
                span.textContent = 'This employers has no vacancies';

                td.appendChild(span);
                tr.appendChild(td);
                body.appendChild(tr);
            }

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
        });
    });
});