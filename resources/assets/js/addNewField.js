function setupDynamicFields(containerId, inputName) {
    const container = document.getElementById(containerId);

    function addField() {
        const group = document.createElement('div');
        group.classList.add('input-group');
        group.classList.add('mt-3');

        group.innerHTML = `
            <input type="text" class="form-control" name="${inputName}[]" required>
            <button type="button" class="btn btn-danger remove-item">-</button>
            <button type="button" class="btn btn-primary add-item">+</button>
        `;

        container.appendChild(group);

        // Attach event listeners to the new buttons
        group.querySelector('.remove-item').addEventListener('click', () => {
            group.remove();
        });

        group.querySelector('.add-item').addEventListener('click', () => {
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
            event.target.closest('.input-group').remove();
        });
    });
}

setupDynamicFields('createResponsibilityInput', 'responsibilities');

setupDynamicFields('createRequirementsInput', 'requirements');

setupDynamicFields('createOffersInput', 'offers');

