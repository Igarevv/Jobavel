<x-header.drop>
    <div class="col-md-7 col-12 py-4">
        <h4 class="text-center text-md-start">Welcome, <span
                    class="fw-bold fst-italic">{{ session('user.name', 'user') }}</span></h4>
        <p class="text-body-secondary text-center text-md-start">
            Employees are individuals who work for an organization or company in exchange for compensation,
            typically in the form of wages or salary.
            They are hired to perform specific tasks and responsibilities as outlined by their employer,
            contributing to the goals and operations of the business.
            Employees work under a contract of employment, which may be permanent, temporary, part-time, or
            full-time, and are subject to the policies and procedures of the organization.
        </p>
        <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between mt-3">
            <a href="{{ route('employee.main') }}" class="btn btn-outline-danger mb-2 mb-md-0">My Home Page</a>
            <a href="{{ route('vacancies.all') }}" class="btn btn-outline-danger mb-2 mb-md-0">All vacancies</a>
            <a href="{{ '#' }}" class="btn btn-outline-secondary mb-2 mb-md-0">Support</a>
            <a href="{{ '#' }}" class="btn btn-outline-info mb-2 mb-md-0">Account Settings</a>
        </div>
    </div>
    <div class="col-md-4 offset-md-1 col-12 py-4">
        <div class="d-flex flex-column flex-md-row gap-3">
            <x-header.navli name="My vacancy" color="info">
                <x-header.li><a href="{{ route('employee.vacancy.applied') }}"
                                class="text-light link-secondary d-block">Applied vacancies</a>
                </x-header.li>
                <x-header.li><a href="{{ route('employee.cv.create') }}"
                                class="text-light link-secondary d-block">My CV file</a>
                </x-header.li>
            </x-header.navli>
        </div>
    </div>
</x-header.drop>
