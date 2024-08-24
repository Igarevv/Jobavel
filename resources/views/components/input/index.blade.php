@props([
    'label',
    'id',
    'value' => '',
    'formType' => 'control',
    'labelType' => 'label',
    'required' => false,
    'hidden' => false,
])

@isset($label)
    <label for="{{ $id }}" id="{{ $id }}-label" class="{{ 'form-'.$labelType }} fw-bold">{{ $label }}</label>
@endisset
<input id="{{ $id }}" {{ $attributes->class(['form-'.$formType]) }} @isset($value) value="{{ $value }} @endisset"
        {{ $attributes->merge(['type' => 'text']) }}
        @required($required) {{ $hidden ? 'hidden' : '' }}>
