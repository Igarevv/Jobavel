<x-layout class="d-flex flex-column min-vh-100">
    <x-header></x-header>
    <x-main>
        <div class="container">
            <div class="my-5">
                <div class="text-center d-flex align-items-center flex-column">
                    @session('cv-deleted')
                    <div class="alert alert-success">
                        {{ $value }}
                    </div>
                    @endsession
                    @session('cv-not-found')
                    <div class="alert alert-danger">
                        {{ $value }}
                    </div>
                    @endsession
                    @session('cv-not-deleted')
                    <div class="alert alert-danger">
                        {{ $value }}
                    </div>
                    @endsession
                </div>
                @if($filename !== null)
                    <h3 class="text-center fw-bold">Your current CV file</h3>
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="square-block text-center">
                                    <div>
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public_static')->url('cv.png') }}"
                                             alt="CV" class="img-fluid w-50 h-50">
                                        <p class="mt-3">{{ $filename }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center align-items-center gap-3 mt-3">
                        <a href="{{ route('employee.resume', ['employee' => session('user.emp_id'), 'type' => 'file']) }}"
                           target="_blank" class="btn btn-outline-primary">
                            View CV
                        </a>
                        <form action="{{ route('employee.cv.destroy') }}" method="POST">
                            @csrf
                            <x-button.outline type="submit" colorType="danger">Delete CV</x-button.outline>
                        </form>
                    </div>
                @endif
            </div>

            <div class="my-5">
                <h3 class="text-center fw-bold">Upload or change your CV file</h3>

                <div class="d-flex justify-content-center w-100 mt-3">
                    <form action="{{ route('employee.cv.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p>Upload CV file</p>
                        <div class="d-flex align-items-center gap-3">
                            <x-input.index type="file" name="cv" id="CVFileUpload"></x-input.index>
                            <x-button.default type="submit" colorType="primary">Upload
                            </x-button.default>
                        </div>
                    </form>
                </div>
                @error('cv')
                <p class="text-center fw-bold text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </x-main>
    <x-footer></x-footer>
</x-layout>
