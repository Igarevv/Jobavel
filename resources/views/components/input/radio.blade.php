@props([
    'id' => null,
    'name',
    'label',
    'value',
    'checked' => false
])

<div class="form-check">
    <input class="form-check-input" type="radio" name="{{ $name }}"
           id="{{ $id ?: $value }}" value="{{ $value }}" @checked($checked)>
    <label class="form-check-label" for="{{ $id ?: $value }}">
        {{ $label }}
    </label>
</div>
