<div class="overflow-auto w-50" @style(['height:50vh'])>
    <ul class="list-unstyled text-14 ps-1">
        @foreach($skillSet as $chunk)
            @foreach($chunk as $key => $skills)
                <span class="red fw-bold">{{ $key }}</span>
                @foreach($skills as $skill)
                    <li>
                        <x-input.block form="check">
                            <input class="form-check-input" type="checkbox" id="check{{ $skill->id }}"
                                   name="{{ $name }}[]" @checked($isChecked($skill->id, old($name, [])))
                                   value="{{ $skill->id }}">
                            <label for="check{{ $skill->id }}">{{ $skill->skillName }}</label>
                        </x-input.block>
                    </li>
                @endforeach
            @endforeach
        @endforeach
    </ul>
</div>
