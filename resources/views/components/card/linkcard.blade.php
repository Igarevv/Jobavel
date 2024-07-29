@props([
    'href' => ''
])
<a href="{{ $href }}" {{ $attributes->class('col-md-4 custom-col-lg-3 mb-4 text-decoration-none hover-overlay') }}>
    <div class="card border shadow-sm h-100 link-card-background">
        <div class="card-body d-flex align-items-center justify-content-center">
            <div class="text-center my-3">
                {{ $slot }}
            </div>
        </div>
    </div>
</a>
