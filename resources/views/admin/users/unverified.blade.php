<x-admin.layout>
    <x-admin.header>
        <x-slot:title>Users > Unverified</x-slot:title>
        In this section, you can manage unverified users.
    </x-admin.header>

    <section class="mx-auto w-3/4 my-10">
        @if($users->count() === 0)
            <section class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                    <div class="mx-auto max-w-screen-sm text-center">
                        <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-8xl text-gray-600 dark:text-white">
                            Oops.</h1>
                        <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">
                            Users not found</p>
                        <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">That's means, that all users
                            have already verified their accounts</p>
                        <a href="#"
                           class="inline-flex text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-100 dark:focus:ring-primary-900 my-4">Show
                            deleted users</a>
                    </div>
                </div>
            </section>
        @else
            @session('emails-sent')
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
            @session('errors')
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                 role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Error!</span> {{ $value }}
                </div>
            </div>
            @endsession
            @session('user-deleted')
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
            <x-admin.table.default>
                <x-slot:title>Unverified users</x-slot:title>
                <x-slot:description>You can delete or send verification email again.
                    <form action="{{ route('admin.emails.send') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="float-end text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                            Send verification email to all users
                        </button>
                    </form>
                </x-slot:description>
                <x-admin.table.thead>
                    <th scope="col" class="px-3 py-3 text-sm">No.</th>
                    <th scope="col" class="px-3 py-3 text-sm">User Id</th>
                    <th scope="col" class="px-3 py-3 text-sm">Email</th>
                    <th scope="col" class="px-3 py-3 text-sm">Account created at</th>
                    <th scope="col" class="px-3 py-3 text-sm">Delete</th>
                </x-admin.table.thead>
                <x-admin.table.tbody>
                    @foreach($users as $user)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </th>
                            <td class="px-3 py-4">
                                {{ $user->idEncrypted }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $user->createdAt }}
                            </td>
                            <td class="px-3 py-4">
                                <form action="{{ route('admin.unverified.delete', ['identity' => $user->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="unstyled-button font-medium text-red-600 dark:text-blue-500 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-admin.table.tbody>
            </x-admin.table.default>
            <div class="mt-1">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </section>
</x-admin.layout>