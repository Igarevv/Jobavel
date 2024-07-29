<x-layout>
    <x-slot:title>{{ session('user.name') ?? config('app.name') }} </x-slot:title>

    <x-header></x-header>

    <x-main class="flex-1">
        <div class="container mt-5 mb-5">
            <div class="text-center">
                <h2 class="fw-bold">Your company unpublished vacancies</h2>
                <h5 class="fw-bold text-muted">Please, before publishing, make sure that your vacancy is ready to be
                    published</h5>
            </div>
            @session('vacancy-added')
            <div class="alert text-center alert-success fw-bold">
                {{ $value }}
            </div>
            @endsession
            @session('vacancy-trashed')
            <div class="alert text-center alert-success fw-bold">
                {{ $value }}
            </div>
            @endsession
            @session('vacancy-restored')
            <div class="alert text-center alert-success fw-bold">
                {{ $value }}
            </div>
            @endsession
            @session('errors')
            <div class="alert text-center alert-danger fw-bold">
                {{ $value }}
            </div>
            @endsession
            @if($vacancies->isEmpty())
                <div class="d-flex flex-column align-items-center justify-content-center vh-70">
                    <h1 class="text-danger fw-bold">Vacancies not found</h1>
                    <p class="text-muted text-sm">Create a new one or check your trashed vacancies</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('employer.vacancy.create') }}" class="btn btn-danger">Create new vacancy</a>
                        <a href="{{ route('employer.vacancy.trashed') }}" class="btn btn-danger">View my trash</a>
                    </div>
                </div>
            @else
                <section class="intro vh-70">
                    <div class="h-100">
                        <div class="d-flex align-items-center h-100">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="card bg-dark shadow-table">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-dark table-borderless mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">NO.</th>
                                                            <th scope="col">ID</th>
                                                            <th scope="col">TITLE</th>
                                                            <th scope="col">SALARY</th>
                                                            <th scope="col">CREATED AT</th>
                                                            <th scope="col">UPDATED AT</th>
                                                            <th scope="col"></th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vacancies as $vacancy)
                                                            <tr class="align-middle">
                                                                <td>{{ $loop->iteration + ($vacancies->currentPage() - 1) * $vacancies->perPage() }}</td>
                                                                <td>{{ $vacancy->id }}</td>
                                                                <td>{{ $vacancy->title }}</td>
                                                                <td>{{ $vacancy->salary }}</td>
                                                                <td>{{ $vacancy->created_at }}</td>
                                                                <td>{{ $vacancy->updated_at ?? "Not updated yet"}}</td>
                                                                <td class="text-center">
                                                                    <a href="{{ route('vacancies.show', ['vacancy' => $vacancy->id]) }}"
                                                                       class="btn btn-outline-light">Show
                                                                        Preview</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ route('employer.vacancy.publish', ['vacancy' => $vacancy->id]) }}"
                                                                          method="POST">
                                                                        @csrf
                                                                        <x-button.outline colorType="success"
                                                                                          type="submit">Publish
                                                                        </x-button.outline>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mt-3">
                                                    {{ $vacancies->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </x-main>
    @once
        @push('vacancy-css')
            <link nonce="{{ csp_nonce() }}" href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
        @endpush
    @endonce
    <x-footer></x-footer>
</x-layout>

