@props([
    'id',
    'label',
    'name',
    'required' => false,
    'value'
])

<h6 class="fw-bold text-decoration-underline">{{ $label }}</h6>
<div id="{{ $id }}">
    <div class="input-group">
        <x-input.index type="text" name="{{ $name }}[]" id="{{ $id }}"
                       required="{{ $required }}" value="{{ $value }}"></x-input.index>
        <button type="button" class="btn btn-primary add-item"
                data-target="{{ $id }}">+
        </button>
    </div>
</div>
