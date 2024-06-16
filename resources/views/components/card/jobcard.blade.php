<div class="col-md-6 job-card">
    <div class="card">
        <div class="card-body d-flex align-items-center gap-3">
            <x-image.logo filename="{{ $jobInfo->image }}" imgColSize="2"></x-image.logo>
            <div class="w-100">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title text-start">{{ $jobInfo->position }}</h5>
                    @isset($jobInfo->salary)
                        <h5 class="card-title fw-bold text-end money">{{ $jobInfo->salary }}</h5>
                    @endisset
                </div>
                <h6 class="card-title fw-bolder">{{ $jobInfo->company }}</h6>
                <div class="mb-2">
                    @foreach($jobInfo->skills as $skill)
                        <span class="badge small bg-dark text-light">{{ $skill ?? '' }}</span>
                    @endforeach
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <svg class="float-start" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M12 2C8.14 2 5 5.14 5 9c0 3.86 5 11 7 13.25C14 20 19 12.86 19 9c0-3.86-3.14-7-7-7zm0 11.5c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
                        </svg>
                        <p class="card-text"><small class="text-muted">{{ $jobInfo->address }}</small></p>
                    </div>
                    <small><a href="#" class="red text-end link-offset-2 link-underline-opacity-10 link-underline-opacity-100-hover">Show details ></a></small>
                </div>
            </div>
        </div>
    </div>
</div>
