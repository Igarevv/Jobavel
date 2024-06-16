const inputContainer = document.getElementById('createVacancyInput');

const addBtn = document.querySelector('.add-requirements');

addBtn.addEventListener('click', () => {
    const group = document.createElement('div');
    group.classList.add('input-group');
    group.classList.add('mb-3');

    group.innerHTML = `
          <input type="text" class="form-control" name="requirements[]" required>
          <button type="button" style="background-color: red" class="remove-requirements">-</button>
    `;

    inputContainer.appendChild(group);
});

inputContainer.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-requirements')) {
        e.target.parentNode.remove();
    }
});
