<div class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="settings-modal" tabindex="-1" aria-hidden="true">
    <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white w-full max-w-2xl rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-600">
            <h2 class="text-xl font-bold">Personal - Setting</h2>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="settings-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <div class="p-4 max-h-[60vh] overflow-y-auto">
            <div class="mb-6 border-b border-gray-200 dark:border-gray-600 pb-6">
                <div class="flex justify-around">
                    <div class="flex flex-col text-center">
                        <span>Account Status</span>
                        <div id="settings-status" class="text-white font-bold"></div>
                    </div>
                    <div class="flex flex-col text-center">
                        <span>Account created at</span>
                        <span id="settings-created" class="text-gray-400"></span>
                    </div>
                </div>
            </div>
            <div class="mb-6 border-b border-gray-200 dark:border-gray-600 pb-6">
                <h3 class="text-lg font-medium mb-4">Your name</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <label for="first-name" class="block text-sm font-medium mb-1 w-1/4">First Name</label>
                        <input
                            type="text"
                            id="settings-first-name"
                            class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-3 rounded border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 w-3/4"
                        />
                    </div>
                    <div class="flex items-center space-x-4">
                        <label for="last-name" class="block text-sm font-medium mb-1 w-1/4">Last Name</label>
                        <input
                            type="text"
                            id="settings-last-name"
                            class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-3 rounded border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 w-3/4"
                        />
                    </div>
                </div>
            </div>

            <div class="mb-6 border-b border-gray-200 dark:border-gray-600 pb-6">
                <h3 class="text-lg font-medium mb-4">Email</h3>
                <div class="flex items-center space-x-4">
                    <label for="email" class="block text-sm font-medium mb-1 w-1/4">Email</label>
                    <input
                        type="email"
                        id="settings-email"
                        class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-3 rounded border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 w-3/4"
                    />
                </div>
            </div>

            <div class="mb-6 border-b border-gray-200 dark:border-gray-600 pb-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-medium mb-4">Password Reset</h3>
                    <span class="italic text-gray-600">Last reset: <span id="last-reset-at"></span></span>
                </div>
                <form action="{{ route('admin.reset-password') }}" id="reset-form" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <label for="current-password" class="block text-sm font-medium mb-1 w-1/4">Current Password</label>
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                placeholder="********"
                                class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-3 rounded border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 w-3/4"
                                required
                            />
                        </div>
                        <div class="flex items-center space-x-4">
                            <label for="new-password" class="block text-sm font-medium mb-1 w-1/4">New Password</label>
                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                placeholder="********"
                                class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-3 rounded border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 w-3/4"
                                required
                            />
                        </div>
                        <div class="flex items-center space-x-4">
                            <label for="confirm-new-password" class="block text-sm font-medium mb-1 w-1/4">Confirm New Password</label>
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                placeholder="********"
                                class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white p-3 rounded border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 w-3/4"
                                required
                            />
                        </div>
                        <div class="flex flex-col">
                            <span class="text-center text-red-100 font-bold text-sm" id="form-errors-span"></span>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex justify-end p-4 border-t border-gray-200 dark:border-gray-600">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                Save Changes
            </button>
            <button data-modal-hide="settings-modal" class="bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold py-2 px-6 rounded ml-4">
                Close
            </button>
        </div>
    </div>
</div>
