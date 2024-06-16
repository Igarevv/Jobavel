<div class="scrollable-list">
    <ul class="list-unstyled">
        @foreach($parameters as $parameter)
            <li>
                <x-input.block form="check">
                    <x-input.index id="check{{ $loop->index }}" type="checkbox"
                                   formType="check-input" labelType="check-label"
                                   label="{{ $parameter }}" value="{{ $parameter }}">
                    </x-input.index>
                </x-input.block>
            </li>
        @endforeach
    </ul>
</div>
