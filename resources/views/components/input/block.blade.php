@props([
    'form' => 'group'
])

<div {{ $attributes->class('form-'.$form) }}>
    {{ $slot }}
</div>
