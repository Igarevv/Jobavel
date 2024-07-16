@props([
    'id',
    'label',
    'name',
    'required' => false,
    'value' => []
])

<h6 class="fw-bold text-decoration-underline">{{ $label }}</h6>
<div id="{{ $id }}">
    <div class="input-group">
        <x-input.index type="text" name="{{ $name }}[]" id="{{ $id }}"
                       required="{{ $required }}" value="{{ $value[0] }}"></x-input.index>
        <button type="button" class="btn btn-primary add-item"
                data-target="{{ $id }}">+
        </button>
    </div>

    @foreach($value as $item)
        @if($loop->first)
            @continue
        @endif
        <div class="input-group mt-3">
            <input type="text" class="form-control" name="{{ $name }}[]"
                   required="{{ $required }}" value="{{ $item }}">
            <button type="button" class="btn btn-danger remove-item">-</button>
            <button type="button" class="btn btn-primary add-item">+</button>
        </div>
    @endforeach
</div>
