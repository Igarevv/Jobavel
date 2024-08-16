<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Dashboard</x-slot:title>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia sunt, assumenda dignissimos doloremque
        reiciendis autem iusto saepe ut minima nesciunt?
    </x-admin.header>

    <section class="mt-8 flex flex-col md:flex-row gap-8 justify-center flex-wrap">
        <x-admin.card>
            <x-slot:title>Number of vacancies</x-slot:title>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eveniet, necessitatibus!
        </x-admin.card>
        <x-admin.card>
            <x-slot:title>Number of employers</x-slot:title>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad, fugit.
        </x-admin.card>
        <x-admin.card>
            <x-slot:title>Number of employees</x-slot:title>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad, fugit.
        </x-admin.card>
    </section>

</x-admin.layout>
