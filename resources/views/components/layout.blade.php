@props(['title'])
        <!doctype html>
<html lang="en" data-bs-theme="auto" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/assets/css/app.css', 'resources/assets/js/app.js'])
    @stack('vite')
    <link rel="stylesheet"
          href="https://unpkg.com/bs-brain@2.0.4/components/registrations/registration-3/assets/css/registration-3.css">
</head>

<body {{ $attributes->class([$injectBody ?? '']) }}>

{{ $slot }}
</body>
</html>
