@php
    use App\Persistence\Models\User;
    $role = session('user.role');
@endphp
<header data-bs-theme="dark" class="sticky-top">
    @if($role === User::EMPLOYEE)
        <x-employee.header></x-employee.header>
    @elseif($role === User::EMPLOYER)
        <x-employer.header></x-employer.header>
    @else
        <x-default.header></x-default.header>
    @endif
    <x-header.main></x-header.main>
</header>
