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
                       required="{{ $required }}" value="{{ $value[0] ?? '' }}"></x-input.index>
        <button type="button" class="btn btn-primary add-item"
                data-target="{{ $id }}">+
        </button>
    </div>
    @error($name.'.0')
    <p class="text-danger text-center font-monospace fw-bold mt-2 h6"> {{ $errors->first($name.'.*') }}</p>
    @enderror

    @foreach($value as $key => $item)
        @if($loop->first)
            @continue
        @endif
        <div class="d-flex flex-column group">
            <div class="input-group mt-3">
                <input type="text" class="form-control" name="{{ $name }}[]"
                       required="{{ $required }}" value="{{ $item }}">
                <button type="button" class="btn btn-danger remove-item">-</button>
                <button type="button" class="btn btn-primary add-item">+</button>
            </div>
            @if($errors->has("{$name}.{$key}"))
                <div class="text-danger">
                    @foreach($errors->get("{$name}.{$key}") as $error)
                        <p class="text-danger text-center font-monospace fw-bold mt-2 h6 flash-{{ $name }}">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
