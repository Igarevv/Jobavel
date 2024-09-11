<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Users > Unverified</x-slot:title>
        In this section, you can manage unverified users.
    </x-admin.header>

    <section class="mx-auto w-3/4 my-10">
        @session('emails-sent')
        <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
        @endsession
        @session('errors')
        <x-admin.alerts.error>{{ $value }}</x-admin.alerts.error>
        @endsession
        @session('user-deleted')
        <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
        @endsession
        <x-admin.table.default>
            <x-slot:title>
                <div class="flex flex-col">
                    <span>Unverified users</span>
                    <span>Found: <span id="foundRecords"></span> records</span>
                </div>
            </x-slot:title>
            <x-slot:description>You can delete or send verification email again.
                <div class="flex justify-end gap-5">
                    <div class="text-center items-center max-w-lg">
                        <div class="flex">
                            <form action="{{ route('admin.users.emails.send') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Send verification email to all users
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <button type="button" id="refreshTable"
                                class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Refresh
                        </button>
                        <span class="text-green-400 text-xs mt-2" id="refresh-span"></span>
                    </div>
                </div>
            </x-slot:description>
            <x-admin.table.thead>
                <th scope="col" class="px-3 py-3 text-sm">No.</th>
                <th scope="col" class="px-3 py-3 text-sm">User Id</th>
                <th scope="col" class="px-3 py-3 text-sm">Email</th>
                <th scope="col" class="px-3 py-3 text-sm">
                    <button type="button" class="sort-link flex items-center space-x-1" data-sort="creation-time">
                        <span class="uppercase">Account created at</span>
                        <svg class="w-4 h-4 text-gray-800 dark:text-black" aria-hidden="true" id="asc-icon"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m5 15 7-7 7 7"/>
                        </svg>
                        <svg class="w-4 h-4 text-red-100 dark:text-white" aria-hidden="true" id="desc-icon"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 9-7 7-7-7"/>
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-3 py-3 text-sm">Delete</th>
            </x-admin.table.thead>
            <x-admin.table.tbody class="unverified-body">
                <!--From JS-->
            </x-admin.table.tbody>
        </x-admin.table.default>
        <div class="pagination-container">
            <!-- Pagination from same JS -->
        </div>
    </section>

    @pushonce('vite')
        @vite(['resources/assets/js/admin/tables/unverifiedTable.js'])
    @endpushonce
</x-admin.layout>
