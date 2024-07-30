<x-header.drop>
    <div class="col-sm-8 col-md-7 py-4">
        <h4>Welcome here</h4>
        <p class="text-body-secondary">
            Employers play a crucial role in the economy, shaping the workforce and driving industry
            innovations.
            They range from small businesses to large multinational corporations, each with unique dynamics,
            challenges, and contributions to society.
        </p>
        <div class="d-flex justify-content-between">
            <a href="{{ route('vacancies.all') }}" class="btn btn-outline-danger">Show me vacancies</a>
            <a href="{{ '#' }}" class="btn btn-outline-secondary">Support</a>
        </div>
    </div>
    <div class="col-sm-4 offset-md-1 py-4">
        <div class="d-flex flex-column h-100 justify-content-center align-items-center">
            <h3 class="text-center mb-4">To start, let's register now</h3>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('employer.register') }}" class="btn btn-outline-danger">as Employer</a>
                <a href="{{ route('employee.register') }}" class="btn btn-outline-danger">as Employee</a>
            </div>
        </div>
    </div>
</x-header.drop>
