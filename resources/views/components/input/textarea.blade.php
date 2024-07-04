@props(['id' => '', 'label' => '', 'name', 'required' => false])

@if(trim($label) !== '')
    <label for="{{ $id }}" class="form-label fw-bold">{{ $label }}</label>
@endif

<textarea id="{{ $id }}"
          name="{{ $name }}" {{ $attributes->merge(['class' => 'form-control']) }} @required($required)>{{ $slot }}</textarea>
