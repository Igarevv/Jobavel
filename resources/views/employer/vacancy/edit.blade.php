<x-layout class="d-flex flex-column min-vh-100">
    <x-slot:title>{{ session('user.name') }}</x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-3 mb-3">
            <h5 class="text-center fw-light">Edit data for your</h5>
            <h1 class="text-center fw-bold text-danger red">{{ session('user.name') }}</h1>
            <h5 class="text-center fw-light">company vacancy</h5>
            @session('edit-errors')
            <div class="alert text-center alert-danger fw-bold">
                {{ $value }}
            </div>
            @endsession
            <div class="w-75 mx-auto">
                @session('edit-errors')
                <div class="alert text-center alert-danger fw-bold">
                    {{ $value }}
                </div>
                @endsession
                <form action="{{ route('vacancies.edit', ['vacancy' => $vacancy->id]) }}" method="POST">
                    @csrf
                    <x-input.block id="createVacancyInput">
                        <div class="my-5">
                            <h6 class="fw-bold text-decoration-underline">Choose skills that will be required for
                                vacancy</h6>
                            <h6 class="mt-3">Your current skills in
                                vacancy: <span @style(['text-decoration: underline', 'text-decoration-color: red'])
                                               class="fw-bold">{{ implode(', ', $existingSkills->names) }}</span>
                            </h6>
                            <x-categories.list name="skillset" :skillSet="$skills"
                                               :existingSkills="$existingSkills"></x-categories.list>
                            @error('skillset')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">Job title (ex. Middle Laravel Developer)</h6>
                            <x-input.index type="text"
                                           id="jobTitle" name="title" value="{{ old('title') ?? $vacancy->title }}"
                                           required></x-input.index>
                            @error('title')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">Location (ex. USA, New Your or Work on
                                distance)</h6>
                            <x-input.index type="text"
                                           id="location" name="location"
                                           value="{{ old('location') ?? $vacancy->location }}"
                                           required></x-input.index>
                            @error('location')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">Salary in USD. (Optional. If you leave it
                                empty or 0, salary
                                field will automatically set as 'Negotiated salary')</h6>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <x-input.index type="number" name="salary" id="salary"
                                               value="{{ old('salary') ?? $vacancy->salary }}"
                                               min="0"></x-input.index>
                            </div>
                            @error('salary')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">About job</h6>
                            <x-input.textarea rows="5" name="description"
                                              required>{{ old('description') ?? str($vacancy->description)->squish() }}</x-input.textarea>
                            @error('description')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <x-input.dynamic.field id="createResponsibilityInput" name="responsibilities"
                                                   required
                                                   :value="old('responsibilities') ?? $vacancy->responsibilities"
                                                   label="Responsibilities (ex. Write clean, efficient and testable code)"></x-input.dynamic.field>
                        </div>
                        <div class="mb-5">
                            <x-input.dynamic.field id="createRequirementsInput" name="requirements" required label="Requirements (ex. Well-knowing
                                PHP,
                                basic of docker etc.)"
                                                   :value="old('requirements') ?? $vacancy->requirements"></x-input.dynamic.field>
                        </div>
                        <div class="mb-5">
                            <x-input.dynamic.field id="createOffersInput" name="offers"
                                                   :value="old('offers') ?? $vacancy->offers"
                                                   label="Job offers(ex. Medical insurance...) (Optional. You may leave it as empty field)"></x-input.dynamic.field>
                        </div>
                    </x-input.block>
                    <x-button.default class="float-end mb-5" type="submit">Save changes</x-button.default>
                </form>
            </div>
        </div>
    </x-main>

    <x-footer></x-footer>

    <script src="/assets/js/addNewField.js"></script>
</x-layout>
