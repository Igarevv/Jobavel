<div class="col-md-6 job-card {{ $class ?? '' }} w-65">
    <div class="card">
        <div class="card-body d-flex align-items-center gap-3">
            <x-image.logo url="{{ $vacancy->employer->company_logo }}" imgColSize="2"></x-image.logo>
            <div class="w-100">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title text-start fw-bold font-18">{{ $vacancy->title }}</h5>
                    @isset($vacancy->salary)
                        <h5 class="card-title fw-bold text-end money">{{ $vacancy->salary ? '$'.$vacancy->salary : ''}}</h5>
                    @endisset
                </div>
                <h6 class="card-title text-muted font-14">{{ $vacancy->employer->company_name }}</h6>
                <div class="mb-2">
                    @php
                        $shownSkills = $vacancy->skills->take(5);
                        $hiddenSkills = $vacancy->skills->slice(5);
                    @endphp
                    @foreach($shownSkills as $skill)
                        <span class="badge small bg-dark text-light">{{ $skill->skillName }}</span>
                    @endforeach
                    <div class="d-none hidden-skills">
                        @foreach($hiddenSkills as $skill)
                            <span class="badge small bg-dark text-light">{{ $skill->skillName }}</span>
                        @endforeach
                        <button class="hide-wheel mt-2 text-decoration-underline d-none btn-no-style font-12">
                            Hide
                        </button>
                    </div>
                    @if($hiddenSkills->isNotEmpty())
                        <button class="show-more mt-2 text-decoration-underline btn-no-style font-12">
                            More...
                        </button>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <svg class="float-start" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                             height="18">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M12 2C8.14 2 5 5.14 5 9c0 3.86 5 11 7 13.25C14 20 19 12.86 19 9c0-3.86-3.14-7-7-7zm0 11.5c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
                        </svg>
                        <p class="card-text"><small class="text-muted">{{ $vacancy->location }}</small></p>
                    </div>
                    <small><a href="{{ route('vacancies.show', ['vacancy' => $vacancy->id]) }}"
                              class="red text-end link-offset-2 link-underline-opacity-10 link-underline-opacity-100-hover">Show
                            details ></a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@pushonce('jobcard-script')
    <script nonce="{{ csp_nonce() }}" src="/assets/js/employer/hideShowSkills.js"></script>
@endpushonce