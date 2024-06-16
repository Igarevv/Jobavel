@props(['name', 'color' => 'primary'])

<div class="col-sm-5 offset-md-1 pt-4">
    <h4 class="text-{{ $color }}">{{ $name }}</h4>
    <ul class="list-unstyled">
        {{ $slot }}
    </ul>
</div>

