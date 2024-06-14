<x-header>
    <x-header.drop>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start py-4">
            <div class="col-md-8 py-4">
                <h4>Welcome, {{ 'user' }}</h4>
                <p class="text-body-secondary">
                    Employers play a crucial role in the economy, shaping the workforce and driving industry
                    innovations.
                    They range from small businesses to large multinational corporations, each with unique dynamics,
                    challenges, and contributions to society.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-5 justify-content-center">
                <x-header.navli name="My vacancy" color="info">
                    <x-header.li><a href="#" class="text-light">Home page</a></x-header.li>
                    <x-header.li><a href="#" class="text-light">Vacancy table</a></x-header.li>
                </x-header.navli>
                <x-header.navli name="Actions" color="danger">
                    <x-header.li><a href="#" class="text-light">Create new vacancy</a></x-header.li>
                    <x-header.li><a href="#" class="text-light">Edit vacancies</a></x-header.li>
                </x-header.navli>
                <x-header.navli name="Additional" color="warning">
                    <x-header.li><a href="{{ route('employer.main') }}" class="text-white">Home page</a></x-header.li>
                    <x-header.li><a href="{{ '#' }}" class="text-white">Support</a></x-header.li>
                    <x-header.li><a href="{{ '#' }}" class="text-white">Account settings</a></x-header.li>
                </x-header.navli>
            </div>
        </div>
    </x-header.drop>
</x-header>
