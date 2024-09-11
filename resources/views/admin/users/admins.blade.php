<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Users > Admins</x-slot:title>
        In this section, you can manage with your admins.
    </x-admin.header>

    <x-admin.separate-section>
        <x-slot:title>Authorization and Authentication</x-slot:title>
        <x-slot:description>In this section you have opportunity to create new admin, to manage their
            permission.
        </x-slot:description>
        <x-slot:content>
            <div class="my-10">
                @session('registered')
                <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
                @endsession
                <div class="text-center">
                    <span class="font-bold text-xl">Register new admin</span>
                </div>
                <form class="max-w-md mx-auto my-3" method="POST" action="{{ route('admin.users.admins.register') }}">
                    @csrf
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="floating_email"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                            address</label>
                        @error('email')
                        <span class="text-center text-red-100">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="first_name" id="floating_first_name"
                                   value="{{ old('first_name') }}"
                                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                   placeholder=" " required/>
                            <label for="floating_first_name"
                                   class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                                name</label>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="last_name" id="floating_last_name" value="{{ old('last_name') }}"
                                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                   placeholder=" " required/>
                            <label for="floating_last_name"
                                   class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                                name</label>
                        </div>
                        @error('first_name')
                        <span class="text-center text-red-100">{{ $message }}</span>
                        @enderror
                        @error('last_name')
                        <span class="text-center text-red-100">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        Register
                    </button>
                </form>
            </div>
        </x-slot:content>
    </x-admin.separate-section>

    <section class="w-4/5 mx-auto my-8 p-6 bg-gray-100 rounded-lg shadow-lg">
        <h3 class="font-bold text-xl mb-4">Admin list</h3>
        <div>
            <p class="text-gray-700">List of admins will be displayed here.</p>
            <div class="my-5">
                <x-admin.table.default>
                    <x-slot:title>
                        <div class="flex flex-col">
                            <span>Admins</span>
                            <span>Found: <span id="foundRecords"></span> records</span>
                        </div>
                    </x-slot:title>
                    <x-slot:description>
                        <div class="float-end flex flex-col">
                            <button type="button" id="refreshTable"
                                    class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                Refresh
                            </button>
                            <span class="text-green-400 text-xs mt-2" id="refresh-span"></span>
                        </div>
                    </x-slot:description>
                    <x-admin.table.thead>
                        <th scope="col" class="px-3 py-3 text-sm">No.</th>
                        <th scope="col" class="px-3 py-3 text-sm">Admin Id</th>
                        <th scope="col" class="px-3 py-3 text-sm">
                            <button type="button" class="sort-link flex items-center space-x-1" data-sort="full-name">
                                <span class="uppercase">Full name</span>
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
                        <th scope="col" class="px-3 py-3 text-sm">Email</th>
                        <th scope="col" class="px-3 py-3 text-sm">Account status</th>
                        <th scope="col" class="px-3 py-3 text-sm">
                            <button type="button"
                                    class="sort-link flex items-center space-x-1" data-sort="creation-time"
                                    data-direction="desc">
                                <span class="uppercase">Created at</span>
                                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" id="asc-icon"
                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="m5 15 7-7 7 7"/>
                                </svg>
                                <svg class="w-4 h-4 text-red-100 dark:text-black" aria-hidden="true" id="desc-icon"
                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="m19 9-7 7-7-7"/>
                                </svg>
                            </button>
                        </th>
                        <th scope="col" class="px-3 py-3 text-sm"></th>
                    </x-admin.table.thead>
                    <x-admin.table.tbody class="admins-body">
                        <!--From JS-->
                    </x-admin.table.tbody>
                </x-admin.table.default>
                <div class="pagination-container">
                    <!-- Pagination from same JS -->
                </div>
            </div>
        </div>
    </section>

    @pushonce('vite')
        @vite(['resources/assets/js/admin/tables/adminsTable.js'])
    @endpushonce
</x-admin.layout>
