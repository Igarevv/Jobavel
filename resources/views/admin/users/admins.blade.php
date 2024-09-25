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
        @session('deactivated')
        <x-admin.alerts.success>
            {{ $value }}
        </x-admin.alerts.success>
        @endsession
        @session('activated')
        <x-admin.alerts.success>
            {{ $value }}
        </x-admin.alerts.success>
        @endsession
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
                        <th scope="col" class="px-3 py-3 text-sm">Actions</th>
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

    <div id="popup-deactivate-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="close-modal-btn absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to deactivate this admin?</h3>
                    <div class="flex justify-around">
                        <form action="{{ route('admin.users.admins.deactivate', ['identity' => ':identity']) }}" method="POST" id="deactivate-form">
                            @csrf
                            <button data-modal-hide="popup-deactivate-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                        </form>
                        <button data-modal-hide="popup-deactivate-modal" type="button" class="close-modal-btn py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="popup-activate-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="close-modal-btn absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to activate this admin?</h3>
                    <div class="flex justify-around">
                        <form action="{{ route('admin.users.admins.activate', ['identity' => ':identity']) }}" method="POST" id="activate-form">
                            @csrf
                            <button data-modal-hide="popup-deactivate-modal" type="submit" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                        </form>
                        <button data-modal-hide="popup-deactivate-modal" type="button" class="close-modal-btn py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.modal.index id="actions-modal">
        <x-admin.modal.header>
            <x-slot:title><span class="admin-name font-bold"></span> actions</x-slot:title>
        </x-admin.modal.header>
        <x-admin.modal.content class="content-container relative">
            <div class="modal-loading-overlay" id="modal-loading-overlay">
                <div role="status" id="loading-spinner">
                    <svg aria-hidden="true"
                         class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-red-600"
                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"/>
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"/>
                    </svg>
                    <span class="sr-only text-black">Loading...</span>
                </div>
            </div>
            <x-admin.table.default>
                <x-slot:title>Admin Action</x-slot:title>
                <x-slot:description>All actions for admin <span class="admin-name font-bold"></span>
                </x-slot:description>
                <x-admin.table.thead>
                    <th scope="col" class="px-3 py-3 text-sm">No.</th>
                    <th scope="col" class="px-3 py-3 text-sm">Actionable</th>
                    <th scope="col" class="px-3 py-3 text-sm">ID</th>
                    <th scope="col" class="px-3 py-3 text-sm">Action name</th>
                    <th scope="col" class="px-3 py-3 text-sm">Reason</th>
                    <th scope="col" class="px-3 py-3 text-sm">Performed At</th>
                </x-admin.table.thead>
                <x-admin.table.tbody class="table-body"/>
            </x-admin.table.default>
            <div class="pagination-container-modal mt-4"></div>
        </x-admin.modal.content>
        <x-admin.modal.footer/>
    </x-admin.modal.index>

    @pushonce('vite')
        @vite(['resources/assets/js/admin/tables/adminsTable.js', 'resources/assets/js/admin/adminActionsTable.js'])
    @endpushonce

    <script nonce="{{ csp_nonce() }}" defer>
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('deactivate-modal-btn')) {
                const modalElement = document.getElementById('popup-deactivate-modal');

                activateModal(modalElement);

                const form = document.getElementById('deactivate-form');
                form.action = form.getAttribute('action').replace(':identity', e.target.getAttribute('data-id'));
            }

            if (e.target.classList.contains('activate-modal-btn')) {
                const modalElement = document.getElementById('popup-activate-modal');

                activateModal(modalElement);

                const form = document.getElementById('activate-form');
                form.action = form.getAttribute('action').replace(':identity', e.target.getAttribute('data-id'));
            }

            function activateModal(modalElement) {
                const modal = new Modal(modalElement);
                modal.show();

                const closeModalBtn = modalElement.querySelectorAll('.close-modal-btn');
                closeModalBtn.forEach(button => {
                    button.addEventListener('click', () => {
                        modal.hide();
                    });
                });
            }
        });
    </script>

</x-admin.layout>
