<x-layout>
    <x-slot:title>{{ session('user.name') }} </x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-5 mb-5">
            @if($vacancies->isEmpty())
                <div class="text-center">
                    <h2 class="fw-bold">Your trashed vacancies</h2>
                    <h5 class="fw-bold text-muted">Here you can restore or permanently delete your vacancy</h5>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 70vh;">
                    <h1 class="text-danger fw-bold">Vacancies not found</h1>
                    <p class="text-muted text-sm">Create a new one or check your trashed vacancies</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('employer.vacancy.create') }}" class="btn btn-danger">Create new vacancy</a>
                        <a href="{{ route('employer.vacancy.trashed') }}" class="btn btn-danger">View my trash</a>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <h5 class="fw-light">company</h5>
                    <h1 class="red text-decoration-underline fw-bold fw-italic">{{ session('user.name') }}</h1>
                    <h4 class="fw-light">Total number of vacancy</h4>
                    <h5 class="fw-normal mb-5">{{ $vacancies->total() }}</h5>
                </div>
                <div class="row" @style(['border: 5px solid #212529', 'border-radius: 0% 10% 10% 0%'])>
                    <div class="col-md-3 filter-column">
                        <div class="d-flex flex-column" @style(['max-height:60%'])>
                            <h4 class="text-center fw-bold">Filters</h4>
                            <h6>By technology</h6>
                            <x-catalog.filterul :skillSet="$skills"></x-catalog.filterul>
                        </div>
                    </div>

                    <div class="col-md-9 content-column">
                        <h4 class="text-center fw-bold">List of your vacancies</h4>
                        <div class="d-flex flex-column align-items-center">
                            @foreach($vacancies as $vacancy)
                                <div class="d-flex align-items-center justify-content-center gap-5">
                                    <x-card.jobcard :vacancy="$vacancy"></x-card.jobcard>
                                    <a href="{{ route('employer.vacancy.show.edit', ['vacancy' => $vacancy->id]) }}"
                                       class="btn btn-outline-primary">Edit</a>
                                    <form action="{{ route('employer.vacancy.unpublish', ['vacancy' => $vacancy->id]) }}"
                                          method="POST">
                                        @csrf
                                        <x-button.outline colorType="danger"
                                                          type="submit">Unpublish
                                        </x-button.outline>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $vacancies->links() }}
                </div>
            @endif
        </div>
    </x-main>

    <x-footer></x-footer>
</x-layout>