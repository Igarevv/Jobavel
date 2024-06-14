@props([
    'type' => 'light',
    'name'
])

<div class="text-center">
    <span class="text-{{ $type }} text-center">{{ $name }}</span>
    <div class="d-flex flex-column gap-2">
        {{ $slot }}
    </div>
</div>
