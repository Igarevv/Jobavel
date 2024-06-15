@props([
    'title',
    'btnActionName',
    'actionPath',
    'method' => 'POST',
    'enctype' => 'application/x-www-form-urlencoded'
])

<form action="{{ $actionPath }}" method="{{ $method }}" enctype="{{ $enctype }}">
    <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div {{ $attributes->class('modal-body') }}>
        {{ $slot }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">{{ $btnActionName }}</button>
    </div>
</form>
