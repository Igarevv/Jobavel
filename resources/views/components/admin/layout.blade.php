<!doctype html>
<html x-data="{ darkMode: localStorage.getItem('dark') === 'true'}"
      x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
      x-bind:class="{ 'dark': darkMode }" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Jobavel Admin' }}</title>
    @vite(['resources/assets/css/admin.css', 'resources/assets/js/admin.js'])
    <meta property="csp-nonce" content="{{ csp_nonce() }}">
    @stack('vite')
</head>

<body class="flex flex-col min-vh-100">
<div class="flex min-vh-100 bg-white dark:bg-gray-900">
    <x-admin.sidebar/>
    <x-admin.banners.reset-password/>
    <div class="p-4 sm:ml-64 flex-grow">
        <div class="p-4 rounded-lg dark:border-gray-700 mt-14">
            {{ $slot }}
            <x-admin.footer/>
        </div>
    </div>
</div>
</body>
@stack('scripts')
</html>
