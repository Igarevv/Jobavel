@props(['name', 'color' => 'primary'])

<div class="col-sm-4 offset-md-1 pt-4">
    <h4 class="text-{{ $color }}">{{ $name }}</h4>
    <ul class="list-unstyled">
        {{ $slot }}
    </ul>
</div>

