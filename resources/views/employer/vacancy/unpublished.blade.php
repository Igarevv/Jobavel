<x-layout>
    <x-slot:title>{{ session('user.name') ?? config('app.name') }} </x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-5 mb-5">
            <div class="text-center">
                <h2 class="fw-bold">Your company unpublished vacancies</h2>
                <h5 class="fw-bold text-muted">Please, before publishing, make sure that your vacancy is ready to be
                    published</h5>
            </div>
            @empty($vacancies)
                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 70vh;">
                    <h1 class="text-danger fw-bold">Vacancies not found</h1>
                    <p class="text-muted text-sm">Create a new one or check your trashed vacancies</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('employer.vacancy.create') }}" class="btn btn-danger">Create new vacancy</a>
                        <a href="" class="btn btn-danger">View my trash</a>
                    </div>
                </div>
            @else
                <section class="intro">
                    <div class="bg-image h-100">
                        <div class="mask d-flex align-items-center h-100">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="card shadow-2-strong">
                                            <div class="card-body p-0">
                                                <div class="table-responsive table-scroll"
                                                     data-mdb-perfect-scrollbar="true"
                                                     style="position: relative; height: 700px">
                                                    <table class="table table-dark mb-0">
                                                        <thead style="background-color: #393939;">
                                                        <tr class="text-uppercase text-success">
                                                            <th scope="col">No.</th>
                                                            <th scope="col">Vacancy ID</th>
                                                            <th scope="col">Title</th>
                                                            <th scope="col">Salary</th>
                                                            <th scope="col">Created At</th>
                                                            <th scope="col"></th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vacancies as $vacancy)
                                                            <tr class="align-middle">
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $vacancy->id }}</td>
                                                                <td>{{ $vacancy->title }}</td>
                                                                <td>{{ $vacancy->salary }}</td>
                                                                <td>{{ $vacancy->created_at }}</td>
                                                                <td class="text-center">
                                                                    <a href="{{ route('vacancies.show', ['vacancy' => $vacancy->id]) }}"
                                                                       class="btn btn-outline-light">Show Preview</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <x-button.outline colorType="success">Publish
                                                                    </x-button.outline>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endempty
        </div>
    </x-main>
    @once
        @push('vacancy-css')
            <link href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
        @endpush
    @endonce
    <x-footer></x-footer>
</x-layout>

