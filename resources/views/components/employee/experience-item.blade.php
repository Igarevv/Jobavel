@if($data)
    @foreach($data as $index => $experience)
        @php $experience = is_array($experience) ? (object)$experience : $experience @endphp
        <div class="experience-item mb-3">
            <div class="d-flex flex-column flex-md-row px-3 py-2 justify-content-between bg-color-dark">
                <div class="editable-container d-flex flex-column flex-md-row align-items-start align-items-md-center gap-1">
                    <div>
                        <h6 class="editable-input d-inline input-hover-white text-node text-white fw-bold"
                            data-id="previous-position-{{ $index }}">{{ old('experiences.'.$index.'.position') ?? $experience->position ?? '[position]' }}</h6>
                        <input type="text" name="experiences[{{ $index }}][position]"
                               id="previous-position-{{ $index }}"
                               class="form-control d-none"
                               value="{{ old('experiences.'.$index.'.position') ?? $experience->position ?? '' }}">
                    </div>
                    <div>
                        <h6 class="d-inline text-white"> at </h6>
                    </div>
                    <div>
                        <h6 class="editable-input d-inline input-hover-white text-white"
                            data-id="company-{{ $index }}">{{ old('experiences.'.$index.'.company') ?? $experience->company ?? '[company]' }}</h6>
                        <input type="text" name="experiences[{{ $index }}][company]"
                               id="company-{{ $index }}"
                               class="form-control d-none"
                               value="{{ old('experiences.'.$index.'.company') ?? $experience->company ?? '' }}">
                    </div>
                </div>
                <div class="editable-container d-flex flex-column flex-md-row align-items-start align-items-md-center gap-1 mt-2 mt-md-0">
                    <div>
                        <h6 class="editable-input d-inline input-hover-white fw-bold text-white"
                            data-id="from-{{ $index }}">{{ old('experiences.'.$index.'.from') ?? $experience->from ?? '[from]' }}</h6>
                        <input type="date" name="experiences[{{ $index }}][from]"
                               id="from-{{ $index }}"
                               class="form-control d-none"
                               value="{{ old('experiences.'.$index.'.from') ?? $experience->from ?? '' }}">
                    </div>
                    <div>
                        <h6 class="d-inline fw-bold text-white"> ⎯ </h6>
                    </div>
                    <div>
                        <h6 class="editable-input d-inline input-hover-white fw-bold text-white"
                            data-id="to-{{ $index }}">{{ old('experiences.'.$index.'.to') ?? $experience->to ?? '[to]' }}</h6>
                        <input type="date" name="experiences[{{ $index }}][to]"
                               id="to-{{ $index }}"
                               class="form-control d-none"
                               value="{{ old('experiences.'.$index.'.to') ?? $experience->to ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="editable-section mt-2">
                <div class="container">
                    <span class="add-li-field editable-input input-hover text-primary text-center d-block"
                          data-experience-id="{{ $index }}">Add description field</span>
                    <ul id="description-list-{{ $index }}">
                        @if (isset($experience->description) || old('experiences.'.$index.'.description', []))
                            @foreach ((old('experiences.'.$index.'.description') ?? $experience->description) as $descIndex => $description)
                                <li data-id="{{ $index }}" class="mb-2">
                                    <div class="editable-input input-group input-field-{{ $index }} d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                        <span class="text-node input-hover text-14">{{ old('experiences.' . $index . '.$.description.' . $descIndex) ?? $description ?? '[description]' }}</span>
                                        <input type="text"
                                               name="experiences[{{ $index }}][description][]"
                                               class="form-control input-text d-none"
                                               value="{{ old('experiences.' . $index . '.$.description.' . $descIndex) ?? $description ?? '' }}">
                                    </div>
                                    <span class="editable-input remove-item input-hover text-danger d-block mt-2 mt-md-0">Remove field</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="text-danger mb-2">
                @if($errors->has("experiences.$index.*"))
                    {{ $errors->first("experiences.$index.*") }}
                @endif
            </div>
            <button type="button" class="btn btn-danger btn-sm delete-btn mt-2">Delete</button>
        </div>
    @endforeach
@else
    <p class="text-muted">Experience not specified</p>
@endif
