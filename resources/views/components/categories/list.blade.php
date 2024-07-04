@props([
    'name',
    'skills'
])
<div class="categories">
    @forelse($skills as $skill)
        <label class="category-label">
            <input type="checkbox" name="{{ $name }}[]" value="{{ $skill->id }}">
            <span>{{ $skill->skill_name }}</span>
        </label>
    @empty
        <p class="text-center h6 text-danger fw-bold">Skills set not found, please contact to support</p>
    @endforelse
</div>
@once
    @push('vacancy-css')
        <link href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
    @endpush
@endonce

