<x-layout>
    <x-slot:title>{{ session('user.name') ?? config('app.name') }} </x-slot:title>

    <x-header></x-header>

    <x-main class="flex-1">
        <div class="container mt-5 mb-5">
            <div class="text-center">
                <h2 class="fw-bold">Your trashed vacancies</h2>
                <h5 class="fw-bold text-muted">Here you can restore or permanently delete your vacancy</h5>
            </div>
            @session('vacancy-deleted')
            <div class="alert text-center alert-success fw-bold">
                {{ $value }}
            </div>
            @endsession
            @if($vacancies->isEmpty())
                <div class="d-flex flex-column align-items-center justify-content-center vh-70">
                    <h1 class="text-danger fw-bold">Vacancies not found</h1>
                    <p class="text-muted text-sm">Your trash is empty!</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('employer.main') }}" class="btn btn-danger">Back to home</a>
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
                                                                <td>{{ $vacancy->updated_at ?? "Not updated yet"}}</td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-outline-light"
                                                                       href="{{ route('employer.vacancy.trashed.preview', ['vacancy' => $vacancy->slug]) }}">Show</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ route('employer.vacancy.restore', ['vacancy' => $vacancy->slug]) }}"
                                                                          method="POST">
                                                                        @csrf
                                                                        <x-button.outline colorType="success"
                                                                                          type="submit">Restore
                                                                        </x-button.outline>
                                                                    </form>
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ route('employer.vacancy.delete-forever', ['vacancy' => $vacancy->slug]) }}"
                                                                          method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <x-button.outline colorType="danger"
                                                                                          type="submit">Delete forever
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
    <x-footer></x-footer>
</x-layout>

