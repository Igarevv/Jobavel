<x-auth.layout
    @style(['background-color: #e9ecef']) class="d-flex justify-content-center align-items-center vh-100">
    <x-auth.base-block>
        <div class="text-center mb-4 fs-3">
            <a href="{{ config('app.url') }}" class="logo fs-4">
                <strong>Job<span style="color: #f9322c;">avel</span></strong>
            </a>
        </div>
        <div class="card p-4 d-flex gap-3">
            <p class="fs-4 text-center fw-bolder">Please, verify your email address</p>
            <p class="text-start text-secondary fs-6">This is required to access some features</p>
            <p class="text-start text-secondary fs-6">Before proceeding, please check your email for a verification
                link</p>
            <p class="text-start text-secondary fs-6">If you did not receive the email</p>
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>
            </form>
        </div>
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                A fresh verification link has been sent to your email address
            </div>
        @endif
        <p class="text-center mt-4 text-secondary">© 2024 Jobavel. All rights reserved.</p>
    </x-auth.base-block>
</x-auth.layout>
