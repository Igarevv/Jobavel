<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Users > Employees</x-slot:title>
        In this section, you can manage users with role - employee.
    </x-admin.header>

    <section class="mx-auto w-3/4 my-10">
        @if($employees->count() === 0)
            <section class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                    <div class="mx-auto max-w-screen-sm text-center">
                        <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-8xl text-gray-600 dark:text-white">
                            Oops.</h1>
                        <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">
                            Employees not found</p>
                        <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">That means, that no one
                            registered users is employee.</p>
                    </div>
                </div>
            </section>
        @else
            <x-admin.table.default>
                <x-slot:title>Unverified users</x-slot:title>
                <x-slot:description>You can delete or send verification email again.
                </x-slot:description>
                <x-admin.table.thead>
                    <th scope="col" class="px-3 py-3 text-sm">No.</th>
                    <th scope="col" class="px-3 py-3 text-sm">Employee Id</th>
                    <th scope="col" class="px-3 py-3 text-sm">Full name</th>
                    <th scope="col" class="px-3 py-3 text-sm">Position</th>
                    <th scope="col" class="px-3 py-3 text-sm">Email</th>
                    <th scope="col" class="px-3 py-3 text-sm">Created At</th>
                    <th scope="col" class="px-3 py-3 text-sm"></th>
                </x-admin.table.thead>
                <x-admin.table.tbody>
                    @foreach($employees as $employee)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}
                            </th>
                            <td class="px-3 py-4">
                                {{ $employee->id }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $employee->name }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $employee->position }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $employee->email }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $employee->createdAt }}
                            </td>
                            <td class="px-3 py-4">
                                <form action=""
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="unstyled-button font-medium text-red-600 dark:text-blue-500 hover:underline">
                                        Ban
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-admin.table.tbody>
            </x-admin.table.default>
            <div class="mt-1">
                {{ $employees->withQueryString()->links() }}
            </div>
        @endif
    </section>
</x-admin.layout>