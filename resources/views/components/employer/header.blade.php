<x-header.drop>
    <div class="col-sm-8 col-md-7 py-4">
        <h4>Welcome, <span class="fw-bold fst-italic">{{ session('user.name', 'user') }}</span></h4>
        <p class="text-body-secondary">
            Employers play a crucial role in the economy, shaping the workforce and driving industry
            innovations.
            They range from small businesses to large multinational corporations, each with unique dynamics,
            challenges, and contributions to society.
        </p>
        <div class="d-flex justify-content-between">
            <a href="{{ route('employer.main') }}" class="btn btn-outline-danger">Home Page</a>
            <a href="{{ '#' }}" class="btn btn-outline-secondary">Support</a>
            <a href="{{ '#' }}" class="btn btn-outline-info">Account Settings</a>
        </div>
    </div>
    <div class="col-sm-4 offset-md-1 py-4">
        <div class="d-flex gap-3">
            <x-header.navli name="My vacancy" color="info">
                <x-header.li><a href="{{ route('employer.vacancy.index') }}" class="text-light">Published vacancies</a>
                </x-header.li>
                <x-header.li><a href="{{ route('employer.vacancy.unpublished') }}" class="text-light">Unpublished
                        vacancy</a></x-header.li>
            </x-header.navli>
            <x-header.navli name="Actions" color="danger">
                <x-header.li><a href="{{ route('employer.vacancy.create') }}" class="text-light">Create new vacancy</a>
                </x-header.li>
                <x-header.li><a href="#" class="text-light">Edit vacancies</a></x-header.li>
            </x-header.navli>
        </div>
    </div>
</x-header.drop>
