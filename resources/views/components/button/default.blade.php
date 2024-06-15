@props([
    'colorType' => 'primary'
])

<button {{ $attributes->class([
    'btn', 'btn-'.$colorType
])->merge([
    'type' => 'button'
]) }}>{{ $slot }}</button>
