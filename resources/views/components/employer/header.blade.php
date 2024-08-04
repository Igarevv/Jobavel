<x-header.drop>
    <div class="col-md-7 col-12 py-4">
        <h4 class="text-center text-md-start">
            Welcome, <span class="fw-bold fst-italic">{{ session('user.name', 'user') }}</span>
        </h4>
        <p class="text-body-secondary text-center text-md-start">
            Employers play a crucial role in the economy, shaping the workforce and driving industry innovations.
            They range from small businesses to large multinational corporations, each with unique dynamics,
            challenges, and contributions to society.
        </p>
        <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between mt-3">
            <a href="{{ route('employer.main') }}" class="btn btn-outline-danger mb-2 mb-md-0">My Home Page</a>
            <a href="{{ route('vacancies.all') }}" class="btn btn-outline-danger mb-2 mb-md-0">All vacancies</a>
            <a href="{{ '#' }}" class="btn btn-outline-secondary mb-2 mb-md-0">Support</a>
            <a href="{{ '#' }}" class="btn btn-outline-info mb-2 mb-md-0">Account Settings</a>
        </div>
    </div>
    <div class="col-md-4 offset-md-1 col-12 py-4">
        <div class="d-flex flex-column flex-md-row gap-3">
            <x-header.navli name="My vacancy" color="info">
                <x-header.li><a href="{{ route('employer.vacancy.published') }}"
                                class="text-light link-secondary d-block">Published vacancies</a>
                </x-header.li>
                <x-header.li><a href="{{ route('employer.vacancy.unpublished') }}"
                                class="text-light link-secondary d-block">Unpublished vacancies</a></x-header.li>
                <x-header.li><a href="{{ route('employer.vacancy.trashed') }}"
                                class="text-light link-secondary d-block">Trashed vacancies</a></x-header.li>
            </x-header.navli>
            <x-header.navli name="Actions" color="danger">
                <x-header.li><a href="{{ route('employer.vacancy.create') }}"
                                class="text-light link-secondary d-block">Create new vacancy</a>
                </x-header.li>
            </x-header.navli>
        </div>
    </div>
</x-header.drop>
