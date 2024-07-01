@props(['id' => '', 'label' => '', 'name'])

@if(trim($label) !== '')
    <label for="{{ $id }}" class="form-label fw-bold">{{ $label }}</label>
@endif

<textarea id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-control']) }}>{{ $slot }}</textarea>
