@props([
    'label' => '',
    'id',
    'value' => '',
    'required' => false,
    'hidden' => false,
])

@isset($label)
    <label for="{{ $id }}" class="form-label fw-bold">{{ $label }}</label>
@endisset
<input id="{{ $id }}" {{ $attributes->class(['form-control']) }} @isset($value)value="{{ $value }}@endisset"
    {{ $attributes->merge(['type' => 'text']) }}
    {{ $required ? 'required' : '' }} {{ $hidden ? 'hidden' : '' }}>
