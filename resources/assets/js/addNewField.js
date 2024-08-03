function setupDynamicFields() {
    document.querySelectorAll('[data-input-name]').forEach(container => {
        const inputName = container.getAttribute('data-input-name');

        function addField() {
            const baseGroup = document.createElement('div');
            baseGroup.classList.add('d-flex', 'flex-column', 'group');

            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group', 'mt-3');

            inputGroup.innerHTML = `
                <input type="text" class="form-control" name="${inputName}[]" required>
                <button type="button" class="btn btn-danger remove-item">-</button>
                <button type="button" class="btn btn-primary add-item">+</button>
            `;
            baseGroup.appendChild(inputGroup);

            container.appendChild(baseGroup);

            inputGroup.querySelector('.remove-item').addEventListener('click', () => {
                baseGroup.remove();
            });

            inputGroup.querySelector('.add-item').addEventListener('click', () => {
                addField();
            });
        }

        container.querySelectorAll('.add-item').forEach(addButton => {
            addButton.addEventListener('click', () => {
                addField();
            });
        });

        container.querySelectorAll('.remove-item').forEach(removeButton => {
            removeButton.addEventListener('click', (event) => {
                event.target.closest('.group').remove();
            });
        });
    });
}

// Вызов функции
setupDynamicFields();
