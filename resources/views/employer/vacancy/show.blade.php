<x-layout>
    <x-slot:title>{{ $vacancy->title ?? 'Jobavel' }}</x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <article>
                        <div class="d-flex align-items-center mb-4">
                            <div class="col-md-2">
                                <img src="{{ $employer->logo }}" class="img-fluid" alt="{{ $employer->company }}">
                            </div>
                            <header class="flex-grow-1 ms-3">
                                <h1 class="fw-bolder mb-1">{{ $vacancy->title }}</h1>
                                <div class="text-muted fst-italic mb-2">
                                    Posted {{ $vacancy->created_at->diffForHumans() }}
                                </div>
                                @foreach($skillSet as $skill)
                                    <span class="badge small bg-dark text-light">{{ $skill->skillName }}</span>
                                @endforeach
                                <p class="fw-bold mt-2">{{ $employer->company }}</span></p>
                            </header>
                        </div>
                        <section class="mb-5">
                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                </svg>
                                @if($vacancy->salary === 0)
                                    <h5 class="fw-bold fst-italic mb-0">Salary: negotiated salary</h5>
                                @else
                                    <h5 class="fw-bold fst-italic mb-0">Salary: <span
                                                class="text-success">${{ $vacancy->salary }}</span></h5>
                                @endif
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                    <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">About us:</h5>
                            </div>
                            <p class="fs-5 mb-4">{{ $employer->description }}</p>

                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                    <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">About work:</h5>
                            </div>
                            <p class="fs-5 mb-4">{{ $vacancy->description }}</p>

                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">Your responsibilities:</h5>
                            </div>
                            <ul class="mb-4 vacancy-ul">
                                @foreach($vacancy->responsibilities as $responsibility)
                                    <li class="fs-6 mb-2">{{ $responsibility }}</li>
                                @endforeach
                            </ul>

                            <div class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     class="float-start me-2" viewBox="0 0 16 16">
                                    <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">We expect from you:</h5>
                            </div>
                            <ul class="mb-4 vacancy-ul">
                                @foreach($vacancy->requirements as $requirement)
                                    <li class="fs-6 mb-2">{{ $requirement }}</li>
                                @endforeach
                            </ul>

                            @isset($vacancy->offers)
                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                         class="float-start me-2" viewBox="0 0 16 16">
                                        <path d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864z"/>
                                        <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1z"/>
                                    </svg>
                                    <h5 class="fw-bold fst-italic mb-0">From our side we offer:</h5>
                                </div>
                                <ul class="mb-4 vacancy-ul">
                                    @foreach($vacancy->offers as $offer)
                                        <li class="fs-6 mb-2">{{ $offer }}</li>
                                    @endforeach
                                </ul>
                            @endempty

                            <div class="d-flex align-items-center mb-3">
                                <svg class="float-start me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     width="18" height="18">
                                    <path fill="none" d="M0 0h24v24H0z"/>
                                    <path d="M12 2C8.14 2 5 5.14 5 9c0 3.86 5 11 7 13.25C14 20 19 12.86 19 9c0-3.86-3.14-7-7-7zm0 11.5c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
                                </svg>
                                <h5 class="fw-bold fst-italic mb-0">Location: {{ $vacancy->location }}</h5>
                            </div>
                        </section>

                    </article>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">Search another vacancies by this categories</div>
                        <div class="card-body d-flex justify-content-center gap-3 flex-wrap">
                            @foreach($skillSet as $skill)
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">
                                            <span
                                                    class="badge small bg-dark text-light">{{ $skill->skillName }}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                    @can(['edit', 'delete', 'publish'], $vacancy)
                        <div class="card mb-4">
                            <div class="card-header">Actions for you</div>
                            <div class="card-body d-flex justify-content-between align-items-center gap-3">
                                <a href="{{ route('employer.vacancy.show.edit', ['vacancy' => $vacancy->id]) }}"
                                   class="btn btn-outline-primary">Edit
                                    vacancy</a>
                                <form action="{{ route('employer.vacancy.destroy', ['vacancy' => $vacancy->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button.outline colorType="danger" type="submit">Move to trash</x-button.outline>
                                </form>
                                @if($vacancy->isPublished())
                                    <form action="{{ route('employer.vacancy.unpublish', ['vacancy' => $vacancy->id]) }}"
                                          method="POST">
                                        @csrf
                                        <x-button.outline colorType="warning" type="submit">Unpublish vacancy
                                        </x-button.outline>
                                    </form>
                                @else
                                    <form action="{{ route('employer.vacancy.publish', ['vacancy' => $vacancy->id]) }}"
                                          method="POST">
                                        @csrf
                                        <x-button.outline colorType="success" type="submit">Publish vacancy
                                        </x-button.outline>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @session('edit-success')
                        <div class="alert alert-success text-center fw-bold">
                            {{ $value }}
                        </div>
                        @endsession
                    @else
                        <div class="card mb-4">
                            <div class="card-header">Apply for a vacancy</div>
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bolder">Number of applies: {{ $vacancy->responses }}</span>
                                </div>
                                <div>
                                    <x-button.outline colorType="danger">Apply</x-button.outline>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </x-main>
    @once
        @push('vacancy-css')
            <link href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
        @endpush
    @endonce
    <x-footer></x-footer>
</x-layout>