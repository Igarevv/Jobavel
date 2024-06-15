@props(['id', 'label', 'name'])

<label for="{{ $id }}" class="form-label fw-bold">{{ $label }}</label>
<textarea id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-control']) }}>{{ $slot }}</textarea>
