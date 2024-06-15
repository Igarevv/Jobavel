@props([
    'form' => 'group'
])

<div {{ $attributes->class('col-12 form-'.$form) }}>
    {{ $slot }}
</div>
