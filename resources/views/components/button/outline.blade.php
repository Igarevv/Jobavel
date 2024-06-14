@props([
    'colorType' => 'primary'
])

<button {{ $attributes->class([
    'btn', 'btn-outline-'.$colorType
        ])->merge([
    'type' => 'button'
    ]) }}>{{ $slot }}
</button>
