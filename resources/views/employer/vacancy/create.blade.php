<x-layout class="d-flex flex-column min-vh-100">
    <x-slot:title>{{ 'Adidas Inc.' }} </x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-3 mb-3">
            <h5 class="text-center fw-light">Create new vacancy for</h5>
            <h1 class="text-center fw-bold text-danger red">{{ session('user.name') }}</h1>
            <h5 class="text-center fw-light">company</h5>
            <div class="w-75 mx-auto">
                <form action="{{ route('employer.vacancy.store') }}" method="POST">
                    @csrf
                    <x-input.block id="createVacancyInput">
                        <div class="my-5">
                            <h6 class="fw-bold text-decoration-underline">Choose skills that will be required for
                                vacancy</h6>
                            <x-categories.list :skills="$skills"></x-categories.list>
                        </div>
                        <div class="mb-5">
                            <x-input.index type="text" label="Job title (ex. Middle Laravel Developer)"
                                           id="jobTitle" name="jobTitle" required></x-input.index>
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">(Optional) Salary in $</h6>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <x-input.index type="number" name="salary" id="salary" min="0"></x-input.index>
                            </div>
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">About job</h6>
                            <x-input.textarea rows="5" name="description"></x-input.textarea>
                        </div>
                        <div class="mb-5">
                            <x-input.field-add id="createResponsibilityInput" name="responsibilities"
                                               label="Responsibilities (ex. Write clean, efficient and testable code)"></x-input.field-add>
                        </div>
                        <div class="mb-5">
                            <x-input.field-add id="createRequirementsInput" name="requirements" label="Requirements (ex. Well-knowing
                                PHP,
                                basic of docker etc.)"></x-input.field-add>
                        </div>
                    </x-input.block>
                    <x-button.default class="float-end mb-5" type="submit">Create vacancy</x-button.default>
                </form>
            </div>
        </div>
    </x-main>

    <x-footer></x-footer>

    <script src="/assets/js/addNewField.js"></script>
</x-layout>
