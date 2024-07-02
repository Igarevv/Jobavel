@props([
    'name',
    'skills'
])
<div class="categories">
    @foreach($skills as $skill)
        <label class="category-label">
            <input type="checkbox" name="{{ $name }}[]" value="{{ $skill->id }}">
            <span>{{ $skill->skill_name }}</span>
        </label>
    @endforeach
</div>
@once
    @push('filters-css')
        <link href="/assets/css/filters.css" type="text/css" rel="stylesheet">
    @endpush
@endonce

