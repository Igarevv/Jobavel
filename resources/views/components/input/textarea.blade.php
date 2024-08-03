@props(['id' => '', 'label' => '', 'name', 'required' => false])

@isset($label)
    <label for="{{ $id }}" id="{{ $id }}-label" class="form-label fw-bold">{{ $label }}</label>
@endisset

<textarea id="{{ $id }}"
          name="{{ $name }}" {{ $attributes->merge(['class' => 'form-control']) }} @required($required)>{{ $slot }}</textarea>
