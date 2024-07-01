function setupDynamicFields(containerId) {
    const container = document.getElementById(containerId);

    function addField() {
        const group = document.createElement('div');
        group.classList.add('input-group');
        group.classList.add('mt-3');

        group.innerHTML = `
            <input type="text" class="form-control" name="items[]" required>
            <button type="button" class="btn btn-danger remove-item">-</button>
            <button type="button" class="btn btn-primary add-item">+</button>
        `;

        container.appendChild(group);

        group.querySelector('.remove-item').addEventListener('click', () => {
            group.remove();
        });

        group.querySelector('.add-item').addEventListener('click', () => {
            addField();
        });
    }

    container.querySelector('.add-item').addEventListener('click', () => {
        addField();
    });
}

setupDynamicFields('createResponsibilityInput');

setupDynamicFields('createRequirementsInput');
