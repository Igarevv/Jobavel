 @props([
    'filename' => 'default_logo.jpg',
    'alt' => 'logo',
    'imgColSize' => 2
])

<div class="col-md-{{ $imgColSize }}">
    <img src="{{ asset('/logo/'.$filename) }}" {{ $attributes->class([
    'img-fluid'
]) }} alt="{{ $alt }}">
</div>
