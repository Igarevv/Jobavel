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

</x-admin.layout>
