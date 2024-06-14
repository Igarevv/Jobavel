@props([
    'type',
    'name',
    'id',
    'placeholder',
    'label',
    'value' => ''
])

<div class="form-floating mb-3">
    <input type="{{ $type }}" class="form-control" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}"
           value="{{ $value }}" required>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
</div>
