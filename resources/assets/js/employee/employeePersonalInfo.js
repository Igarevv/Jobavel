document.addEventListener('DOMContentLoaded', function () {
    function generateRandomString(length = 8) {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return result;
    }

    function makeEditable(element) {
        const id = element.dataset.id;
        const inputElement = document.getElementById(id);
        const originalText = element.textContent.trim();

        if (inputElement) {
            element.classList.add('d-none');
            inputElement.classList.remove('d-none');
            inputElement.focus();

            inputElement.addEventListener('blur', function () {
                const newValue = this.value.trim();
                element.textContent = newValue || originalText;
                element.classList.remove('d-none');
                this.classList.add('d-none');
            });

            inputElement.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    this.blur();
                }
            });
        }
    }

    function attachEditableClickListeners() {
        document.querySelectorAll('.editable-input').forEach(element => {
            element.addEventListener('click', function () {
                makeEditable(this);
            });
        });
    }

    function attachLiInputBlurListeners() {
        document.querySelectorAll('li .input-text').forEach(inputElement => {
            inputElement.addEventListener('blur', function () {
                const li = this.closest('li');
                if (li) {
                    const textNode = li.querySelector('.text-node');
                    const newValue = this.value.trim();
                    textNode.textContent = newValue || textNode.textContent;
                    textNode.classList.remove('d-none');
                    this.classList.add('d-none');
                }
            });

            inputElement.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    this.blur();
                }
            });
        });
    }

    function attachExperienceInputBlurListeners() {
        document.querySelectorAll('.experience-item .input-text').forEach(inputElement => {
            inputElement.addEventListener('blur', function () {
                const editableInput = this.previousElementSibling;
                const newValue = this.value.trim();
                editableInput.textContent = newValue || editableInput.textContent;
                editableInput.classList.remove('d-none');
                this.classList.add('d-none');
            });

            inputElement.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    this.blur();
                }
            });
        });
    }

    function attachDeleteButtonListener(deleteButton) {
        deleteButton.addEventListener('click', function () {
            const experienceItem = this.closest('.experience-item');
            if (experienceItem) {
                experienceItem.remove();
            }
        });
    }

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const experienceItem = this.closest('.experience-item');
            if (experienceItem) {
                experienceItem.remove();
            }
        })
    })

    attachEditableClickListeners();
    attachLiInputBlurListeners();
    attachExperienceInputBlurListeners();

    let experienceCount = 0;

    const experienceContainer = document.getElementById('experience-container');

    if (experienceContainer) {
        experienceContainer.addEventListener('click', function (event) {
            if (event.target.matches('.add-li-field')) {
                const experienceId = event.target.getAttribute('data-experience-id');
                const ul = document.getElementById(`description-list-${experienceId}`);
                const li = document.createElement('li');
                const inputFieldId = generateRandomString();

                li.setAttribute('data-id', inputFieldId);

                li.innerHTML = `
                <div class="editable-input input-group d-flex justify-content-between align-items-center">
                    <span class="text-node input-hover text-14">[description]</span>
                    <input type="text" name="experiences[${experienceId}][description][]" 
                           class="form-control input-text d-none" value="" id="${inputFieldId}">
                </div>
                <span class="editable-input remove-item input-hover text-danger">Remove field</span>
            `;
                ul.appendChild(li);
                attachEditableClickListeners();
                attachLiInputBlurListeners();
            }
        });

        experienceContainer.addEventListener('click', function (event) {
            if (event.target.matches('.text-node')) {
                const li = event.target.closest('li');
                if (li) {
                    const input = li.querySelector('.input-text');
                    event.target.classList.add('d-none');
                    input.classList.remove('d-none');
                    input.focus();
                }
            }

            if (event.target.matches('.remove-item')) {
                const li = event.target.closest('li');
                if (li) {
                    li.remove();
                }
            }
        });
    }

    document.getElementById('add-more').addEventListener('click', function () {
        let newExperience = document.createElement('div');
        newExperience.classList.add('experience-item', 'mb-3');
        const experienceId = generateRandomString();

        newExperience.innerHTML = `
            <div class="d-flex px-3 py-2 justify-content-between bg-color-dark">
                <div class="editable-container d-flex align-items-center gap-1">
                    <div>
                        <h6 class="editable-input d-inline input-hover-white text-node fw-bold text-white"
                            data-id="previous-position-${experienceId}">[position]</h6>
                        <input type="text" name="experiences[${experienceId}][position]"
                               id="previous-position-${experienceId}"
                               class="form-control d-none input-text"
                               value="">
                    </div>
                    <div>
                        <h6 class="d-inline text-white"> at </h6>
                    </div>
                    <div>
                        <h6 class="editable-input d-inline input-hover-white text-node text-white"
                            data-id="company-${experienceId}">[company]</h6>
                        <input type="text" name="experiences[${experienceId}][company]" id="company-${experienceId}"
                               class="form-control d-none input-text"
                               value="">
                    </div>
                </div>
                <div class="editable-container d-flex align-items-center gap-1">
                    <div>
                        <h6 class="editable-input d-inline input-hover-white fw-bold text-node text-white"
                            data-id="from-${experienceId}">[from]</h6>
                        <input type="date" name="experiences[${experienceId}][from]" id="from-${experienceId}"
                               class="form-control d-none input-text"
                               value="">
                    </div>
                    <div>
                        <h6 class="d-inline fw-bold text-white"> ⎯ </h6>
                    </div>
                    <div>
                        <h6 class="editable-input d-inline input-hover-white fw-bold text-node text-white"
                            data-id="to-${experienceId}">[to]</h6>
                        <input type="date" name="experiences[${experienceId}][to]" id="to-${experienceId}"
                               class="form-control d-none input-text"
                               value="">
                    </div>
                </div>
            </div>
            <div class="editable-section">
                <div class="container">
                    <span class="add-li-field editable-input input-hover text-primary" data-experience-id="${experienceId}">Add description field</span>
                    <ul id="description-list-${experienceId}"></ul>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
        `;

        experienceContainer.appendChild(newExperience);

        const deleteButton = newExperience.querySelector('.delete-btn');
        attachDeleteButtonListener(deleteButton);

        attachEditableClickListeners();
        attachExperienceInputBlurListeners();

        experienceCount++;
    });
});
