@props([
    'name'
])

@if(old($name))
    @foreach(old($name) as $key => $value)
        @if($loop->first)
            @error($name . '.0')
            <p class="text-danger text-center font-monospace fw-bold mt-2 h6"> {{ $errors->first($name.'.*') }}</p>
            @enderror
            @continue
        @endif
        <div class="input-group mt-3">
            <input type="text" class="form-control" name="{{ $name }}[]"
                   value="{{ $value ?? '' }}" required>
            <button type="button" class="btn btn-danger remove-item">-</button>
            <button type="button" class="btn btn-primary add-item">+</button>
        </div>
        @if($errors->has("{$name}.{$key}"))
            <div class="text-danger">
                @foreach($errors->get("{$name}.{$key}") as $error)
                    <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    @endforeach
@endif

