<x-header.drop>
    <div class="col-sm-8 col-md-7 py-4">
        <h4>Welcome, <span class="fw-bold fst-italic">{{ session('user.name', 'user') }}</span></h4>
        <p class="text-body-secondary">Employees are individuals who work for an organization or company in exchange for
            compensation, typically in the form of wages or salary.
            They are hired to perform specific tasks and responsibilities as outlined by their employer, contributing to
            the goals and operations of the business.
            Employees work under a contract of employment, which may be permanent, temporary, part-time, or full-time,
            and are subject to the policies and procedures of the organization.</p>
        <div class="d-flex justify-content-between">
            <a href="{{ route('employee.main') }}" class="btn btn-outline-danger">My Home Page</a>
            <a href="{{ route('vacancies.all') }}" class="btn btn-outline-danger">All vacancies</a>
            <a href="{{ '#' }}" class="btn btn-outline-secondary">Support</a>
            <a href="{{ '#' }}" class="btn btn-outline-info">Account Settings</a>
        </div>
    </div>
    <div class="col-sm-4 offset-md-1 py-4">
        <h4>Contact</h4>
        <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
        </ul>
    </div>
</x-header.drop>
