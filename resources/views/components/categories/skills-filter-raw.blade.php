@pushonce('vacancy-css')
    <link nonce="{{ csp_nonce() }}" href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
@endpushonce

<div class="overflow-auto vh-50">
    @foreach($skillSet as $chunk)
        @foreach($chunk as $key => $skills)
            <div class="skill-group">
                <span class="alphabet-letter">{{ $key }}</span>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                        <label class="category-label-raw text-14" for="{{ $skill->id }}">
                            <input type="checkbox" name="{{ $name }}[]" value="{{ $skill->id }}"
                                   id="{{ $skill->id }}" @checked($isChecked($skill->id, old($name, [])))>
                            <span class="skill-name">{{ $skill->skillName }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endforeach
</div>
