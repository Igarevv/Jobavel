@props([
    'name',
    'label',
    'value',
])

<div class="form-check">
    <input class="form-check-input" type="radio" name="{{ $name }}"
           id="{{ $value }}" value="{{ $value }}">
    <label class="form-check-label" for="{{ $value }}" @checked(old($name) === $value)>
        {{ $label }}
    </label>
</div>