@props([
   'filename' => 'default_logo.png',
   'alt' => 'logo',
   'imgColSize' => 2
])

<div class="col-md-{{ $imgColSize }} d-flex align-items-center">
    <img src="{{ asset('/img/logo/'.$filename) }}" {{ $attributes->class([
    'img-fluid'
]) }} alt="{{ $alt }}">
</div>
