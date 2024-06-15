 @props([
    'filename' => 'default_logo.png',
    'alt' => 'logo',
    'imgColSize' => 2
])

<div class="col-md-{{ $imgColSize }} mt-2">
    <img src="{{ asset('/logo/'.$filename) }}" {{ $attributes->class([
    'img-fluid'
]) }} alt="{{ $alt }}">
</div>
