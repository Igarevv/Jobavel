<x-layout class="d-flex flex-column min-vh-100">
    <x-slot:title>{{ 'Adidas Inc.' }} </x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-3 mb-3">
            <h5 class="text-center fw-light">Create new vacancy for</h5>
            <h1 class="text-center fw-bold text-danger red">{{ 'Adidas.Inc' }}</h1>
            <h5 class="text-center fw-light">company</h5>
            <div class="w-75 mx-auto">
                <form action="" method="POST">
                    <x-input.block id="createVacancyInput">
                        <x-input.index class="mb-3" type="text" label="Job title (ex. Middle Laravel Developer)"
                                       id="jobTitle" name="jobTitle" required></x-input.index>
                        <h6 class="fw-bold">(Optional) Salary in $</h6>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <x-input.index type="number" name="salary" id="salary" min="0"></x-input.index>
                        </div>
                        <x-input.textarea class="mb-3" name="description" label="About job"
                                          id="description"></x-input.textarea>
                        <h6 class="fw-bold">Requirements to employee (ex. Well-knowing PHP, basic of docker etc.)</h6>
                        <div class="input-group mb-3">
                            <x-input.index type="text" name="requirements[]" id="tmp" required></x-input.index>
                            <button type="button" class="btn btn-primary add-requirements">+</button>
                        </div>
                    </x-input.block>
                </form>
            </div>
        </div>
    </x-main>

    <x-footer></x-footer>

    <script src="/assets/js/addNewField.js"></script>
</x-layout>
