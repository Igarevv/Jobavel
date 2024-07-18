<div class="overflow-auto" @style(['height:50vh'])>
    <ul class="list-unstyled">
        @foreach($skillSet as $chunk)
            @foreach($chunk as $key => $skills)
                <span class="red fw-bold">{{ $key }}</span>
                @foreach($skills as $skill)
                    <li>
                        <x-input.block form="check">
                            <x-input.index id="check{{ $loop->index }}" type="checkbox"
                                           formType="check-input" labelType="check-label"
                                           label="{{ $skill->skillName }}" value="{{ $skill->id }}">
                            </x-input.index>
                        </x-input.block>
                    </li>
                @endforeach
            @endforeach
        @endforeach
    </ul>
</div>