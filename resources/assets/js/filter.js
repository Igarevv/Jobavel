document.addEventListener('DOMContentLoaded', () => {
    const rangeInput = document.getElementById('rangeInput');
    const numberInput = document.getElementById('numberInput');
    const salaryOutput = document.getElementById('salaryOutput');

    rangeInput.addEventListener('change', (e) => {
        const value = e.target.value;
        salaryOutput.textContent = `$${value}`;
        numberInput.value = value;
    });

    numberInput.addEventListener('input', (e) => {
        const value = e.target.value;
        salaryOutput.textContent = `$${value}`;
        rangeInput.value = value;
        salaryOutput.value = '$' + this.value;
    });

    salaryOutput.textContent = `$${rangeInput.value}`;
    numberInput.value = rangeInput.value;


    const form = document.getElementById('filterForm');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const data = new FormData(e.target);
        let baseUrl = form.getAttribute('data-url');
        let skillsInRaw = 'skills=' + data.getAll('skills[]').join();
        let url = new URL(baseUrl);
        let params = new URLSearchParams();
        let skills = data.getAll('skills[]');
        if (skills.length > 0) {
            params.append('skills', skills.join());
        }
        let salary = data.get('salary');
        if (salary > 0) {
            params.append('salary', salary);
        }
        ['location', 'employment', 'experience', 'consider'].forEach(field => {
            let value = data.get(field);
            if (value) {
                params.append(field, value);
            }
        });
        url.search = params.toString();
        history.pushState(null, '', url.toString());
        fetch(url.toString(), {
            method: 'GET'
        }).then(() => {
            window.location.reload();
        });
    });
});
