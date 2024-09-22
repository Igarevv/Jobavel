@php use App\Enums\Actions\BanDurationEnum;use App\Enums\Admin\AdminEmployeesSearchEnum as SearchEnum; @endphp
<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Users > Employees</x-slot:title>
        In this section, you can manage users with role - employee.
    </x-admin.header>

    <section class="mx-auto w-3/4 my-10">
        <x-admin.table.default>
            <x-slot:title>
                <div class="flex flex-col">
                    <span>Employees</span>
                    <span>Found: <span id="foundRecords"></span> records</span>
                </div>
            </x-slot:title>
            <x-slot:description>
                <span>You can delete or send verification email again.</span>
                <div class="flex items-center justify-between">
                    <div class="text-center items-center max-w-lg mx-auto">
                        <div class="flex">
                            <div class="relative">
                                <select id="searchBy"
                                        name="searchBy"
                                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600 appearance-none">
                                    <option disabled hidden value selected>Choose column</option>
                                    @foreach (SearchEnum::columns() as $value => $label)
                                        <option value="{{ $value }}" @selected(old('searchBy') === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="relative w-[512px]">
                                <input type="search" id="search-dropdown"
                                       name="search"
                                       value=""
                                       class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-red-500"
                                       placeholder="Search..." required/>
                                <button type="submit" id="searchBtn"
                                        class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-red-700 rounded-e-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round" stroke-width="2"
                                              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                    <span class="sr-only">Search</span>
                                </button>
                            </div>
                        </div>
                        <span class="text-sm text-red-100" id="search-validation-error"></span>
                    </div>
                    <div class="flex justify-end flex-col">
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
                <th scope="col" class="px-3 py-3 text-sm">Employee Id</th>
                <th scope="col" class="px-3 py-3 text-sm">
                    <button type="button"
                            class="sort-link flex items-center space-x-1" data-sort="full-name"
                            data-direction="desc">
                        <span class="uppercase">Full Name</span>
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
                <th scope="col" class="px-3 py-3 text-sm">Position</th>
                <th scope="col" class="px-3 py-3 text-sm">Email</th>
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
            <x-admin.table.tbody class="employees-body">
                <!--From JS-->
            </x-admin.table.tbody>
        </x-admin.table.default>
        <div class="pagination-container">
            <!-- Pagination from same JS -->
        </div>
    </section>

    <x-admin.modal.index id="ban-employee-modal" class="relative p-4 w-full max-w-xl max-h-full">
        <x-admin.modal.header>
            <x-slot:title>Ban employee - <span class="employer-name font-bold"></span></x-slot:title>
        </x-admin.modal.header>
        <x-admin.modal.content class="content-container relative">
            <form class="max-w-sm mx-auto flex flex-col gap-3" id="ban-form"
                  action="{{ route('admin.users.employees.ban', ['employee' => ':id']) }}" method="POST">
                @csrf
                <div>
                    <label for="reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        reason type</label>
                    <select id="reason" name="reason_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                        @foreach(\App\Enums\Actions\ReasonToBanEmployeeEnum::cases() as $enum)
                            <option
                                value="{{ $enum->value }}" @selected($enum === \App\Enums\Actions\ReasonToBanEmployeeEnum::INAPPROPRIATE_CONTENT)>{{ $enum->toString() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="duration" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        reason type</label>
                    <select id="duration" name="duration"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                        @foreach(BanDurationEnum::cases() as $enum)
                            <option
                                value="{{ $enum->value }}" @selected($enum === BanDurationEnum::DAY)>{{ $enum->toString() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Additional
                        message (optional)</label>
                    <textarea id="message" rows="2" name="comment"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>
                <button type="submit"
                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    Ban
                </button>
            </form>
        </x-admin.modal.content>
        <x-admin.modal.footer></x-admin.modal.footer>
    </x-admin.modal.index>

    @pushonce('vite')
        @vite(['resources/assets/js/admin/tables/employeeTable.js'])
    @endpushonce
</x-admin.layout>
