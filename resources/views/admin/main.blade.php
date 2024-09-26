@php use App\Enums\Admin\AdminStatisticsEnum; @endphp
<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Dashboard</x-slot:title>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia sunt, assumenda dignissimos doloremque
        reiciendis autem iusto saepe ut minima nesciunt?
    </x-admin.header>

    <section class="mt-8 flex flex-col md:flex-row gap-8 justify-center flex-wrap">
        <x-admin.card link="{{ route('admin.vacancies.index') }}">
            <x-slot:title>Number of vacancies</x-slot:title>
            The difference with the previous month
            @if($statistic === null)
                <p class="text-center text-xl font-bold">--</p>
            @else
                <p class="text-center text-xl font-bold {{ $statistic->vacancies->type->color() }}">{{ $statistic->vacancies->value }}</p>
                @if($statistic->vacancies->type === AdminStatisticsEnum::MORE_THAN_WAS)
                    <x-admin.statistic-icons.up></x-admin.statistic-icons.up>
                @elseif($statistic->vacancies->type === AdminStatisticsEnum::LESS_THAN_WAS)
                    <x-admin.statistic-icons.down></x-admin.statistic-icons.down>
                @else
                    <x-admin.statistic-icons.straight></x-admin.statistic-icons.straight>
                @endif
            @endif
        </x-admin.card>
        <x-admin.card link="{{ route('admin.users.employers') }}">
            <x-slot:title>Number of employers</x-slot:title>
            The difference with the previous month
            @if($statistic === null)
                <p class="text-center text-xl font-bold">--</p>
            @else
                <p class="text-center text-xl font-bold {{ $statistic->employers->type->color() }}">{{ $statistic->employers->value }}</p>
                @if($statistic->employers->type === AdminStatisticsEnum::MORE_THAN_WAS)
                    <x-admin.statistic-icons.up></x-admin.statistic-icons.up>
                @elseif($statistic->employers->type === AdminStatisticsEnum::LESS_THAN_WAS)
                    <x-admin.statistic-icons.down></x-admin.statistic-icons.down>
                @else
                    <x-admin.statistic-icons.straight></x-admin.statistic-icons.straight>
                @endif
            @endif
        </x-admin.card>
        <x-admin.card link="{{ route('admin.users.employees') }}">
            <x-slot:title>Number of employees</x-slot:title>
            The difference with the previous month
            @if($statistic === null)
                <p class="text-center text-xl font-bold">--</p>
            @else
                <p class="text-center  text-xl font-bold {{ $statistic->employees->type->color() }}">{{ $statistic->employees->value }}</p>
                @if($statistic->employees->type === AdminStatisticsEnum::MORE_THAN_WAS)
                    <x-admin.statistic-icons.up></x-admin.statistic-icons.up>
                @elseif($statistic->employees->type === AdminStatisticsEnum::LESS_THAN_WAS)
                    <x-admin.statistic-icons.down></x-admin.statistic-icons.down>
                @else
                    <x-admin.statistic-icons.straight></x-admin.statistic-icons.straight>
                @endif
            @endif
        </x-admin.card>
    </section>

    <section class="mt-14 flex flex-col justify-center flex-wrap">
        <p class="text-3xl font-bold text-center">Admins</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 justify-items-center mt-8">
            @foreach($admins as $admin)
                <div class="max-w-xs w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 relative">
                    <div class="flex flex-col items-center py-10">
                        <svg class="w-16 h-16 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $admin->name }} <span class="font-bold">{{ auth('admin')->id() === $admin->id ? '(You)' : '' }}</span></h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ auth('admin')->user()->isSuperAdmin() ? $admin->email : '' }}</span>
                    </div>
                    <div class="absolute top-2 right-2">
                        @if($admin->isOnline)
                            <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                        Online
                    </span>
                        @else
                            <span class="inline-flex items-center bg-tailwind-red-100 text-tailwind-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-tailwind-red-900 dark:text-tailwind-red-300">
                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                        Offline
                    </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </section>
</x-admin.layout>
