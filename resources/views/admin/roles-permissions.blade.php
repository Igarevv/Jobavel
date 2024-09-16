<x-admin.layout>
    <x-admin.header>
        <x-slot:title>
            Roles and permissions
            @if(auth('admin')->user()?->can('permissions-view') && auth('admin')->user()?->cannot('permissions-manage'))
                <span class="text-red-100">(read-only)</span>
            @endif
        </x-slot:title>
        <span class="text-yellow-800 bg-yellow-300 dark:bg-gray-900 dark:text-yellow-300 px-1">Attention!</span>
        In this section, you must manage roles and permissions carefully, otherwise users may do things
        they are now allowed to do.
    </x-admin.header>

    <section class="w-full my-10">
        <div class="flex gap-8 w-full justify-around mb-8">
            <div class="flex flex-col items-center gap-8">
                <div class="w-full">
                    @session('role-created')
                    <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
                    @endsession
                    <x-admin.table.default class="w-full" scroll>
                        <x-slot:title>Roles</x-slot:title>
                        <x-slot:description>Manage all roles used in the application.</x-slot:description>
                        <x-admin.table.thead>
                            <th scope="col" class="px-3 py-2 text-sm w-30">No.</th>
                            <th scope="col" class="px-3 py-2 text-sm">Role</th>
                            <th scope="col" class="px-3 py-2 text-sm">Created At</th>
                            <th scope="col" class="px-3 py-2 text-sm">Updated At</th>
                            <th scope="col" class="px-3 py-2 text-sm w-20"></th>
                        </x-admin.table.thead>
                        <x-admin.table.tbody>
                            @forelse($roles as $role)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="ps-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white w-30">{{ $loop->iteration }}</th>
                                    <td class="ps-3 py-4">{{ $role->name }}</td>
                                    <td class="ps-3 py-4">{{ $role->createdAt }}</td>
                                    <td class="ps-3 py-4">{{ $role->updatedAt }}</td>
                                    <td class="pe-3 py-4 text-right w-20">
                                        <form action="{{ route('admin.roles.remove', ['role' => $role->id]) }}"
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
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th>
                                        <p class="m-5 text-red-100">Roles not found</p>
                                    </th>
                                </tr>
                            @endforelse
                        </x-admin.table.tbody>
                    </x-admin.table.default>
                </div>
                <x-admin.card-icon>
                    <x-slot:icon>
                        <svg class="h-8 w-8 text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                            <path d="M16 11h6m-3 -3v6"/>
                        </svg>
                    </x-slot:icon>
                    <x-slot:title>
                        Role creation or editing
                    </x-slot:title>
                    <x-slot:description>
                        Create new role, that will be used by someone on application.
                    </x-slot:description>
                    <form action="{{ route('admin.role.store') }}" class="max-w-sm mx-auto" method="POST">
                        @csrf
                        <div class="flex gap-3 items-center">
                            <div>
                                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role
                                    name</label>
                                <input type="text" name="role" id="role" value="{{ old('role') ?? '' }}"
                                       aria-describedby="helper-text-explanation"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-30 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="role">
                            </div>
                            <div class="flex gap-3 items-end">
                                <div>
                                    <label for="guard1"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guard</label>
                                    <select id="guard1" name="guard"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @foreach($guards as $guard)
                                            <option @selected($guard === 'web') value="{{ $guard }}">{{ $guard }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit"
                                            class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Please,
                            use lowercase.</p>
                        @error('role')
                        <span class="text-red-100">{{ $message }}</span>
                        @enderror
                        @session('role-error')
                        <span class="text-red-100">{{ $value }}</span>
                        @endsession
                    </form>
                </x-admin.card-icon>
            </div>

            <div class="flex flex-col items-center gap-8">
                <div class="w-full">
                    @session('permission-created')
                    <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
                    @endsession
                    @session('permission-not-found')
                    <x-admin.alerts.error>{{ $value }}</x-admin.alerts.error>
                    @endsession
                    @session('permission-revoked')
                    <x-admin.alerts.success>{{ $value }}</x-admin.alerts.success>
                    @endsession
                    <x-admin.table.default class="w-full" scroll>
                        <x-slot:title>Permissions</x-slot:title>
                        <x-slot:description>Manage all permissions for roles.</x-slot:description>

                        <x-admin.table.thead>
                            <th scope="col" class="px-3 py-2 text-sm w-14">No.</th>
                            <th scope="col" class="px-3 py-2 text-sm">Permission</th>
                            <th scope="col" class="px-3 py-2 text-sm w-20">Guard</th>
                            <th scope="col" class="px-3 py-2 text-sm">Created At</th>
                            <th scope="col" class="px-3 py-2 text-sm">Updated At</th>
                            <th scope="col" class="px-3 py-2 text-sm w-20"></th>
                        </x-admin.table.thead>

                        <x-admin.table.tbody>
                            @php
                            $iteration = 0;
                            @endphp
                            @forelse($guardedPermissions as $permissionsByGuard)
                                @foreach($permissionsByGuard as $permission)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="ps-3 py-2 font-medium text-gray-900 text-sm whitespace-nowrap dark:text-white w-14">
                                            {{ ++$iteration }}
                                        </th>
                                        <td class="ps-4 py-4">{{ $permission->name }}</td>
                                        <td class="ps-4 py-4 w-20">{{ $permission->guard }}</td>
                                        <td class="ps-4 py-4">{{ $permission->createdAt }}</td>
                                        <td class="ps-4 py-4">{{ $permission->updatedAt }}</td>
                                        <td class="px-4 py-4 text-right w-20">
                                            <form action="{{ route('admin.permissions.remove', ['permission' => $permission->name]) }}"
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
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th colspan="6" class="px-3 py-2 text-center text-red-100">Permissions not
                                        found
                                    </th>
                                </tr>
                            @endforelse
                        </x-admin.table.tbody>
                    </x-admin.table.default>
                </div>

                <x-admin.card-icon>
                    <x-slot:icon>
                        <svg class="h-8 w-8 text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1"/>
                            <circle cx="12" cy="7.5" r=".5" fill="currentColor"/>
                        </svg>
                    </x-slot:icon>
                    <x-slot:title>
                        Permission creation
                    </x-slot:title>
                    <x-slot:description>
                        Create new permission, that will be used assigned by role on application
                    </x-slot:description>
                    <form action="{{ route('admin.permission.store') }}" method="POST" class="max-w-sm mx-auto">
                        @csrf
                        <div class="flex gap-3 items-center">
                            <div>
                                <label for="permission"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Permission
                                    name</label>
                                <input type="text" id="permission" name="permission"
                                       value="{{ old('permission') ?? '' }}" aria-describedby="helper-text-explanation"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-30 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="permission">
                            </div>
                            <div class="flex gap-3 items-end">
                                <div>
                                    <label for="guard2"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guard</label>
                                    <select id="guard2" name="guard"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @foreach($guards as $guard)
                                            <option @selected($guard === 'web') value="{{ $guard }}">{{ $guard }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit"
                                            class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">If your
                            permission name more than 1 word, please use lowercase with '-' separator.</p>
                        @error('permission')
                        <span class="text-red-100">{{ $message }}</span>
                        @enderror
                        @session('permission-error')
                        <span class="text-red-100">{{ $value }}</span>
                        @endsession
                    </form>
                </x-admin.card-icon>
            </div>
        </div>
        <div class="flex flex-col gap-8">
            <div class="flex justify-center gap-8">
                <x-admin.card-icon class="lg:max-w-screen-lg w-full">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" class="h-8 w-8 text-red-500" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                        </svg>
                    </x-slot:icon>
                    <x-slot:title>
                        Link permissions to role
                    </x-slot:title>
                    <x-slot:description>
                        Assign or delete permissions to role
                    </x-slot:description>
                    <div class="w-full">
                        <form action="{{ route('admin.permissions-roles.link') }}" method="POST"
                              class="max-w-lg mx-auto space-y-4 p-4 w-full" id="linkPermissionsToWebForm">
                            @csrf
                            <div class="w-full">
                                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Exists roles</h3>
                                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @php
                                        $roles = $roles->reject(fn(object $role) => $role->name === \App\Persistence\Models\Admin::ADMIN);
                                    @endphp
                                    @forelse($roles as $role)
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <div class="flex items-center ps-3">
                                                <input id="role-{{ $role->id }}" type="radio" value="{{ $role->id }}"
                                                       name="role" data-role-id="{{ $role->id }}"
                                                       @checked($loop->first) class="custom-radio w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="role-{{ $role->id }}"
                                                       class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $role->name }}</label>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="px-3 py-2 text-center text-red-100 text-sm">Roles not found</p>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="grid grid-cols-2 gap-4" id="permissionsList">
                                @foreach($guardedPermissions['web'] ?? [] as $permission)
                                    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                        <input id="permission-{{ $permission->id }}" type="checkbox"
                                               value="{{ $permission->name }}" name="permissions[]"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="permission-{{ $permission->id }}"
                                               class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('role')
                            <span class="mt-2 text-red-100">{{ $message }}</span>
                            @enderror
                            @error('permissions')
                            <span class="mt-2 text-red-100">{{ $message }}</span>
                            @enderror
                        </form>
                        <div>
                            <button type="submit" form="linkPermissionsToWebForm"
                                    class="float-end text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Link permissions to role
                            </button>
                        </div>
                    </div>
                </x-admin.card-icon>
            </div>
            <div class="flex justify-center">
                @session('permissions-linked')
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
                @session('nothing-changed')
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                     role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">{{ $value }}</span>
                    </div>
                </div>
                @endsession
            </div>
            <div class="flex justify-center gap-8">
                <x-admin.card-icon class="lg:max-w-screen-lg w-full">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" class="h-8 w-8 text-red-500" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                        </svg>
                    </x-slot:icon>
                    <x-slot:title>
                        Link permissions to current admin
                    </x-slot:title>
                    <x-slot:description>
                        Assign or delete permissions for current admin
                    </x-slot:description>
                    <div class="w-full">
                        <form action="{{ route('admin.permissions-admin.link') }}" method="POST"
                              class="max-w-lg mx-auto space-y-4 p-4 w-full" id="linkPermissionsToAdminForm">
                            @csrf
                            <div class="w-full text-center">
                                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Admin ID or email</h3>
                                <input type="text" id="user-admin" name="identifier" placeholder="UUID or email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <span class="text-red-100 text-sm" id="live-search-error"></span>
                            </div>
                            <div class="grid grid-cols-2 gap-4" id="permissionsList">
                                @foreach($guardedPermissions['admin'] ?? [] as $permission)
                                    <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                        <input id="permission-admin-{{ $permission->id }}" type="checkbox"
                                               value="{{ $permission->name }}" name="permissions[]"
                                               class="admin-permissions w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="permission-admin-{{ $permission->id }}"
                                               class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('search')
                            <span class="mt-2 text-red-100">{{ $message }}</span>
                            @enderror
                            @error('permissions')
                            <span class="mt-2 text-red-100">{{ $message }}</span>
                            @enderror
                        </form>
                        <div>
                            <button type="submit" form="linkPermissionsToAdminForm"
                                    class="float-end text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Link permissions to admin
                            </button>
                        </div>
                    </div>
                </x-admin.card-icon>
            </div>
        </div>
    </section>

    @pushonce('vite')
        @vite(['resources/assets/js/admin/rolesPermissions.js'])
    @endpushonce
    <script nonce="{{ csp_nonce() }}" async>
        window.Laravel = {!! json_encode(['token' => auth('admin')->user()?->api_token]) !!}
    </script>
</x-admin.layout>
