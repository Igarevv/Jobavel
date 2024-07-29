<x-auth.layout
        class="d-flex justify-content-center align-items-center vh-100 background-white-darker">
    <x-auth.base-block>
        <div class="text-center d-flex justify-content-center mb-4 fs-3">
            <a href="{{ config('app.url') }}" class="text-dark navbar-brand">
                <strong>Job<span class="red">avel</span></strong>
            </a>
        </div>
        <div class="card p-4 d-flex">
            <p class="fs-4 text-center fw-bolder">Please, verify your email address</p>
            <p class="text-start text-center text-secondary fs-6">This is required to access some features</p>
            <p class="text-start text-center text-secondary fs-6">Before proceeding, please check your email for a
                verification
                link</p>
            <p class="text-start text-center text-secondary fs-6">If you did not receive the email</p>
            <form class="d-inline text-center" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="btn btn-link p-0 m-0 align-baseline">click here to request another
                </button>
            </form>
        </div>
        @if (session('email-verify-message'))
            <div class="alert alert-success text-center" role="alert">
                A fresh verification link has been sent to your email address
            </div>
        @endif
        <p class="text-center mt-4 text-secondary">© 2024 Jobavel. All rights reserved.</p>
    </x-auth.base-block>
</x-auth.layout>
