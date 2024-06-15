<x-layout>
    <x-slot:title>Main</x-slot:title>
    <x-employer.header/>

    <div class="album py-5 bg-body-tertiary background-logo"
         style="background: url({{ asset('/logo/Adidas_Logo.jpg') }}) center center/cover no-repeat">
        <div class="container">
            <div class="d-flex align-items-center flex-column">
                <div class="d-flex align-items-center justify-content-center flex-column maxw-25 h-auto" @style(['background-color: white'])>
                    <x-image.logo filename="{{ 'Adidas_Logo.jpg' }}" imgColSize="6"></x-image.logo>
                    <h2 class="text-center fw-bold" @style(['color:#f9322c'])>Adidas Inc.</h2>
                </div>
            </div>
            <div class="row mt-5 justify-content-center">
                <x-employer.statcard>
                    <h3>Your</h3>
                    <h5>total number of vacancy</h5>
                    <p>{{ '0' }}</p>
                </x-employer.statcard>
                <x-employer.statcard>
                    <h3>Your</h3>
                    <h5>total number of responses for today</h5>
                    <p> {{ '0' }}</p>
                </x-employer.statcard>
                <x-employer.statcard>
                    <h3>Your</h3>
                    <h5>total number of responses for month</h5>
                    <p> {{ '0' }}</p>
                </x-employer.statcard>
                <x-employer.statcard>
                    <h3>Your</h3>
                    <h5>top 3 frequent required skills in vacancy</h5>
                    <p> {{ 'Git, Laravel, PHP' }}</p>
                </x-employer.statcard>
            </div>
        </div>
        <div class="blur"></div>
    </div>
    <div class="container" @style(['margin-bottom:6rem'])>
        <h2 class="text-center">Your company public information</h2>
        <form class="w-75 mx-auto">
            <x-input.block form="group" class="d-flex justify-content-between">
                <label class="fw-bold" for="exampleFormControlInput1">Your company logo</label>
                <x-button.outline colorType="danger">Change logo</x-button.outline>
            </x-input.block>
            <x-input.block form="group" class="mb-3">
                <x-input.index type="text" class="py-2" name="companyName" id="companyName" value="Adidas Inc." label="Your company name"></x-input.index>
            </x-input.block>
            <x-input.block form="outline" class="mb-3">
                <x-input.textarea id="description" label="Your company description" name="description"></x-input.textarea>
            </x-input.block>
            <x-input.block form="group" class="mb-3">
                <x-input.index type="email" class="py-2" name="contactEmail" id="contactEmail" value="example@gmail.com" label="Your company contact email"></x-input.index>
            </x-input.block>
            <x-button.default class="float-end" type="submit">Save changes</x-button.default>
        </form>
    </div>
    <x-footer></x-footer>
</x-layout>
