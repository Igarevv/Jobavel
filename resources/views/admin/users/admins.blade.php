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
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                     role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Success!</span> {{ $value }}
                    </div>
                </div>
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

    <!-- Admin List Section -->
    <section class="w-4/5 mx-auto my-8 p-6 bg-gray-100 rounded-lg shadow-lg">
        <h3 class="font-bold text-xl mb-4">Admin list</h3>
        <div>
            <!-- Content related to Admin list goes here. For example, a table or list of admins. -->
            <p class="text-gray-700">List of admins will be displayed here.</p>
        </div>
    </section>

</x-admin.layout>
