<x-layout>
    <x-slot:title>Register</x-slot:title>
    <x-slot:injectBody>background-auth</x-slot:injectBody>

    <section class="form-smaller" @style(['height:100vh'])>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                    <div class="card border border-light-subtle rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <div class="text-center mb-4">
                                            <a href="/" class="navbar-brand d-flex justify-content-center">
                                                <strong
                                                    class="h4">Job<span @style(['color:#f9322c'])>avel</span></strong>
                                            </a>
                                        </div>
                                        <h2 class="h4 text-center">Employee Registration</h2>
                                        <h3 class="fs-6 fw-normal text-secondary text-center m-0">Enter your details to
                                            register</h3>
                                    </div>
                                </div>
                            </div>
                            <form action="#!" method="post">
                                @csrf
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <x-input type="text" name="firstName" id="firstName" placeholder="John"
                                                 label="First name" value="{{ old('firstName') }}"></x-input>
                                        @error('firstName')
                                        <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-input type="text" name="lastName" id="lastName" placeholder="Doe"
                                                 label="Last name" value="{{ old('lastName') }}"></x-input>
                                        @error('lastName')
                                        <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-input type="email" name="email" id="email" placeholder="index@mail.com"
                                                 label="Email" value="{{ old('email') }}"></x-input>
                                        @error('email')
                                        <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-input type="password" name="password" id="password" placeholder="********"
                                                 label="Password"></x-input>
                                    </div>
                                    <div class="col-12">
                                        <x-input type="password" name="password_confirmation" id="password_confirmation"
                                                 placeholder="********"
                                                 label="Confirm password"></x-input>
                                        @error('password')
                                        <p class="text-danger text-center fst-italic fw-bolder h6">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="true" name="iAgree"
                                                   id="iAgree" required>
                                            <label class="form-check-label text-secondary" for="iAgree">
                                                I agree to the <a href="#!" class="link-primary text-decoration-none">terms
                                                    and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn bsb-btn-xl btn-primary" type="submit">Sign up</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">
                                    <hr class="mt-5 mb-4 border-secondary-subtle">
                                    <p class="m-0 text-secondary text-center">Already have an account? <a
                                            href="{{ route('login.show') }}" class="link-primary text-decoration-none">Sign
                                            in</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
