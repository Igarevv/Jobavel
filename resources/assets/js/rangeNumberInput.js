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
    });

    salaryOutput.textContent = `$${rangeInput.value}`;
    numberInput.value = rangeInput.value;
});