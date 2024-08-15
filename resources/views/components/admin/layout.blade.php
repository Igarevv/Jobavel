<!doctype html>
<html x-data="{ darkMode: localStorage.getItem('dark') === 'true'}"
      x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
      x-bind:class="{ 'dark': darkMode }" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Jobavel Admin' }}</title>
    @vite(['resources/assets/css/admin.css', 'resources/assets/js/admin.js'])
</head>

<body>
<div class="flex gap-8 bg-white dark:bg-gray-900">
    <x-admin.sidebar class="min-w-fit flex-grow-0 flex-shrink-0 hidden md:block"/>
    <main class="mt-4 px-4">
        <div class="block sm:absolute top-5 right-8 order-1">
            <x-admin.dark-mode-toggle size="4"/>
        </div>
        {{ $slot }}
        <x-admin.footer/>
    </main>
</div>
</body>

</html>