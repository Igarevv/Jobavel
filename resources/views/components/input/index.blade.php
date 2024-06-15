@props([
    'label',
    'id',
    'value' => '',
    'required' => false
])

<label for="{{ $id }}" class="form-label fw-bold">{{ $label }}</label>
<input id="{{ $id }}" {{ $attributes->class(['form-control']) }} value="{{ $value }}" {{ $attributes->merge(['type' => 'text']) }}  {{ $required ? 'required' : '' }}>
