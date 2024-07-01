<x-layout class="vh-100">
    <x-slot:title>Login</x-slot:title>
    <x-slot:injectBody>background-auth</x-slot:injectBody>

    <x-main>
        <section class="form-smaller" @style(['height:100vh'])>
            <div class="container w-100">
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
                                                        class="h4">Job<span class="red">avel</span></strong>
                                                </a>
                                            </div>
                                            <h2 class="h4 text-center">Log in</h2>
                                            <h3 class="fs-6 fw-normal text-secondary text-center m-0">Enter email and
                                                password
                                                to login</h3>
                                        </div>
                                    </div>
                                </div>
                                <form action="" method="post">
                                    @csrf
                                    <div class="row gy-3 overflow-hidden">
                                        <x-input.block class="col-12">
                                            <x-input.index type="email" name="email" id="email"
                                                           placeholder="example@gmail.com"
                                                           label="Email" value="{{ old('email') }}"
                                                           required></x-input.index>
                                            @error('email')
                                            <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                            @enderror
                                        </x-input.block>
                                        <x-input.block class="col-12">
                                            <x-input.index type="password" name="password" id="password"
                                                           label="Password" value="{{ old('password') }}"
                                                           placeholder="Your password here..."
                                                           required></x-input.index>
                                            @error('password')
                                            <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                            @enderror
                                        </x-input.block>
                                        <x-input.block class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                       name="remember"
                                                       id="remember">
                                                <label class="form-check-label text-secondary" for="remember">
                                                    Remember me
                                                </label>
                                            </div>
                                            @error('remember')
                                            <p class="text-danger fst-italic fw-bolder h6">{{ $message }}</p>
                                            @enderror
                                        </x-input.block>
                                        <x-input.block class="col-12">
                                            <div class="d-grid">
                                                <button class="btn bsb-btn-xl btn-primary" type="submit">Log in
                                                </button>
                                            </div>
                                        </x-input.block>
                                        @session('register-success')
                                        <div class="alert alert-success fw-bold">
                                            {{ $value }}
                                        </div>
                                        @endsession
                                        @session('error')
                                        <div class="alert alert-danger fw-bold">
                                            {{ $value }}
                                        </div>
                                        @endsession
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-12">
                                        <hr class="mt-5 mb-4 border-secondary-subtle">
                                        <p class="text-center">Don't have an account?</p>
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="{{ route('employee.register') }}" class="btn btn-outline-danger">
                                                as Employee
                                            </a>
                                            <a href="{{ route('employer.register') }}" class="btn btn-outline-danger">
                                                as Employer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-main>
</x-layout>
