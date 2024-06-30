<x-auth.layout
    @style(['background-color: #e9ecef']) class="d-flex justify-content-center align-items-center vh-100">
    <x-auth.base-block>
        <div class="text-center mb-4 fs-3">
            <a href="{{ config('app.url') }}" class="logo fs-4">
                <strong>Job<span style="color: #f9322c;">avel</span></strong>
            </a>
        </div>
        <div class="card p-4 d-flex gap-3">
            <p class="fs-3 text-center text-danger fw-bolder">Email confirmation was failed!</p>
            <p class="text-center text-secondary fs-6">Please try again or contact to us</p>
            <div class="d-flex justify-content-center gap-5">
                <a href="{{ route('login.show') }}" class="btn btn-outline-danger">Try again</a>
            </div>
        </div>
        <p class="text-center mt-4 text-secondary">© 2024 Jobavel. All rights reserved.</p>
    </x-auth.base-block>
</x-auth.layout>

