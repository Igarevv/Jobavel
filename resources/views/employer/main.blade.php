<x-layout>
    <x-slot:title>Main</x-slot:title>
    <x-header></x-header>

    <x-main>
        <div class="album py-5 bg-body-tertiary background-logo"
             style="background: url({{ asset('/img/logo/Adidas_Logo.jpg') }}) center center/cover no-repeat;">
            <div class="container">
                <div class="d-flex align-items-center flex-column">
                    <div class="logo-company-name">
                        <x-image.logo class="mt-2" filename="{{ $employer->company_logo }}"
                                      imgColSize="6"></x-image.logo>
                        <h2 class="text-center fw-bold red">{{ session('user.name') }}</h2>
                    </div>
                </div>
                <div class="row mt-5 justify-content-center">
                    <x-card.linkcard href="{{ route('employer.vacancy.published') }}">
                        <h3>Your</h3>
                        <h5>total number of vacancy</h5>
                        <p>{{ 0 }}</p>
                    </x-card.linkcard>
                    <x-card.linkcard>
                        <h3>Your</h3>
                        <h5>total number of responses for today</h5>
                        <p> {{ 0 }}</p>
                    </x-card.linkcard>
                    <x-card.linkcard>
                        <h3>Your</h3>
                        <h5>total number of responses for month</h5>
                        <p> {{ 0 }}</p>
                    </x-card.linkcard>
                    <x-card.linkcard>
                        <h3>Your</h3>
                        <h5>top 3 frequent required skills in vacancy</h5>
                        <p> {{ "Git, Laravel, PHP"}}</p>
                    </x-card.linkcard>
                </div>
            </div>
            <div class="blur"></div>
        </div>

        <div class="container" @style(["margin-bottom:6rem"])>
            <h2 class="text-center mb-3">Your company public information</h2>
            <form class="w-75 mx-auto" method="post" action="{{ route('employer.account.update') }}">
                @session('updated-success')
                <div class="alert alert-success text-center fw-bold my-2">
                    {{ $value }}
                </div>
                @endsession
                @session('verification-success')
                <div class="alert alert-success text-center fw-bold my-2">
                    {{ $value }}
                </div>
                @endsession
                <x-input.block form="group" class="d-flex justify-content-between col-12">
                    @csrf
                    <label class="fw-bold" for="exampleFormControlInput1">Your company logo</label>
                    <x-button.outline data-bs-toggle="modal" data-bs-target="#changeLogo" colorType="danger">Change
                        logo
                    </x-button.outline>
                </x-input.block>
                <x-input.block form="group" class="mb-3 col-12">
                    <x-input.index type="text" class="py-2" name="name" id="companyName"
                                   value="{{ old('name') ?? session('user.name') }}"
                                   label="Your company name"></x-input.index>
                    @error('name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </x-input.block>
                <x-input.block form="outline" class="mb-3 col-12">
                    <x-input.textarea id="description" label="Your company description" rows="5"
                                      name="description">{{ old('description') ?? $employer->company_description }}</x-input.textarea>
                    @error('description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </x-input.block>
                <x-input.block form="group" class="mb-3 col-12">
                    <x-input.index type="email" class="py-2" name="email" id="contactEmail"
                                   value="{{ old('email') ?? $employer->contact_email }}"
                                   label="Your company contact email"></x-input.index>
                    @error('email')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </x-input.block>
                @if(session('frontend.show-button-for-modal'))
                    <x-button.default class="float-start" type="button" data-bs-toggle="modal" colorType="danger"
                                      id="showEnterCodeModal"
                                      data-bs-target="#updatedSuccess">Enter code again
                    </x-button.default>
                @endif
                <x-button.default class="float-end" type="submit">Save changes</x-button.default>
            </form>
        </div>

        <x-modal.index id="updatedSuccess">
            <x-modal.withform title="Enter the confirmation code" btnActionName="Verify contact email"
                              actionPath="{{ route('employer.account.verify-contact-email') }}">
                <x-input.index type="text" id="checkCode" name="code"
                               label="Enter your code from new contact email here"
                               required></x-input.index>
                <x-button.outline colorType="danger" id="resendCodeBtn" class="mt-2">Resend code</x-button.outline>
                @if(session('frontend.code-expired'))
                    <p class="text-danger">{{ session('frontend.code-expired') }}</p>
                @endif
            </x-modal.withform>
        </x-modal.index>

        <x-modal.index id="changeLogo">
            <x-modal.withform title="Change logo" btnActionName="Save changes" actionPath="#"
                              enctype="multipart/form-data" withClose>
                <x-input.index type="file" id="chooseNewLogo" name="logo" label="Choose logo" required></x-input.index>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <x-image.logo id="newLogo" filename="{{ $employer->company_logo }}" imgColSize="3"></x-image.logo>
                </div>
                <p class="text-danger text-center" id="bad-file-extension"></p>
            </x-modal.withform>
        </x-modal.index>
    </x-main>

    <x-footer></x-footer>

    @if(session('frontend.email-updated-success') || session('frontend.code-expired'))
        <script>
            $(document).ready(function () {
                $('#updatedSuccess').modal('show');
            });
        </script>
    @endif

    @push("change-logo")
        <script src="/assets/js/changeLogo.js"></script>
    @endpush

    <script src="/assets/js/verificationCode.js"></script>
</x-layout>
