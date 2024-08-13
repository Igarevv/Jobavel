<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    @vite(['resources/assets/css/app.css', 'resources/assets/js/app.js'])
    <style nonce="{{ csp_nonce() }}">
        .logo {
            text-align: center;
            color: black;
            font-size: 18px;
            text-decoration: none;
        }
    </style>
</head>
<body {{ $attributes->class('vh-100') }}>
{{ $slot }}
</body>
</html>
