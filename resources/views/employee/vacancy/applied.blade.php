<x-layout class="d-flex flex-column min-vh-100">
    <x-slot:title>My applied vacancies</x-slot:title>
    <x-header></x-header>
    <x-main>
        <div class="container mt-5 mb-5">
            <h2 class="text-center mt-5 fw-bold">Your applied vacancies</h2>
            @if($vacancies->isEmpty())
                <div class="d-flex flex-column align-items-center justify-content-center vh-70">
                    <h1 class="text-danger fw-bold">Vacancies not found</h1>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('vacancies.all') }}" class="btn btn-danger">Find more vacancies</a>
                    </div>
                </div>
            @else
                <div class="mt-3">
                    @session('error')
                    <div class="alert alert-danger text-center">
                        {{ $value }}
                    </div>
                    @endsession
                    @session('vacancy-withdraw')
                    <div class="alert alert-success text-center">
                        {{ $value }}
                    </div>
                    @endsession
                    @session('update-success')
                    <div class="alert alert-success text-center">
                        {{ $value }}
                    </div>
                    @endsession
                    @session('nothing-updated')
                    <div class="alert alert-success text-center">
                        {{ $value }}
                    </div>
                    @endsession
                </div>
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
                                                            <th scope="col">TITLE</th>
                                                            <th scope="col">COMPANY</th>
                                                            <th scope="col">YOUR CONTACT EMAIL</th>
                                                            <th scope="col">APPLIED AT</th>
                                                            <th scope="col">CV</th>
                                                            <th scope="col"></th>
                                                            <th scope="col"></th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($vacancies as $vacancy)
                                                            <tr class="align-middle">
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $vacancy->title }}</td>
                                                                <td>{{ $vacancy->company }}</td>
                                                                <td>{{ $vacancy->contactEmail }}</td>
                                                                <td>{{ $vacancy->appliedAt }}</td>
                                                                <td>
                                                                    @if($vacancy->cvFile === false)
                                                                        <a href="{{ route('employee.main') }}"
                                                                           class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                                                            Used manually created CV
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('employee.cv.create') }}"
                                                                           class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                                                            Used CV file
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('vacancies.show', ['vacancy' => $vacancy->slug]) }}"
                                                                       class="btn btn-outline-light">Show vacancy</a>
                                                                </td>
                                                                <td>
                                                                    <x-button.outline colorType="warning"
                                                                                      data-bs-toggle="modal"
                                                                                      class="changeCvOrEmail"
                                                                                      data-vacancy-slug="{{ $vacancy->slug }}"
                                                                                      data-bs-target="#apply-modal">
                                                                        Change CV or email
                                                                    </x-button.outline>
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{ route('vacancies.employee.withdraw', ['vacancy' => $vacancy->slug]) }}"
                                                                          method="POST">
                                                                        @csrf
                                                                        <x-button.outline colorType="danger"
                                                                                          type="submit">Withdraw
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
    <x-modal.index id="apply-modal">
        <x-modal.withform title="Choose your CV" btnActionName="Apply"
                          actionPath="{{ route('employee.vacancy.applied.change', ['vacancy' => ':slug']) }}"
                          formId="changeForm"
                          withClose>
            <div class="d-flex justify-content-center gap-3">
                <div class="custom-radio">
                    <input type="radio" id="option1" name="cvType" class="custom-control-input" value="0" required
                            @checked(old('cvType') == \App\Persistence\Models\Employee::CV_TYPE_MANUAL)>
                    <label class="custom-control-label p-3" for="option1">
                        <a href=""
                           class="link-offset-2 text-decoration-none">
                            <span>Manually</span> <span>created</span> <span>CV</span>
                        </a>
                    </label>
                </div>
                <div class="custom-radio">
                    <input type="radio" id="option2" name="cvType" class="custom-control-input" value="1"
                           required @checked(old('cvType') == \App\Persistence\Models\Employee::CV_TYPE_FILE)>
                    <label class="custom-control-label py-3 px-4" for="option2">
                        <a href=""
                           class="link-offset-2 text-decoration-none">
                            <span>Use</span> <span>my file</span> <span>CV</span>
                        </a>
                    </label>
                </div>
            </div>
            <div class="my-2">
                <h6>Your contact email:</h6>
                <div class="input-group">
                    <div class="input-group-text">
                        <label for="checkboxEmail" class="me-2">Use account email</label>
                        <input class="form-check-input mt-0" type="checkbox" value="1" name="useCurrentEmail"
                               aria-label="Checkbox for following text input"
                               id="checkboxEmail" @checked(old('useCurrentEmail') == 1)>
                    </div>
                    <input type="email" class="form-control" aria-label="Text input with checkbox"
                           name="contactEmail" value="{{ old('contactEmail') ?? '' }}">
                </div>
            </div>
            <span class="text-danger">{{ $errors->first() }}</span>
        </x-modal.withform>
    </x-modal.index>
    <x-footer></x-footer>

    @if($errors->any())
        <script type="module">
            $(document).ready(function () {
                $('#apply-modal').modal('show');
            });
        </script>
    @endif

    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('changeForm');

            document.querySelectorAll('.changeCvOrEmail').forEach(button => {
                button.addEventListener('click', () => {
                    const vacancySlug = button.getAttribute('data-vacancy-slug');
                    const action = form.getAttribute('action').replace(':slug', vacancySlug);
                    form.setAttribute('action', action);
                })
            });
        });
    </script>
</x-layout>
