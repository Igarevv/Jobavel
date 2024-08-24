<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body class="background-white-darker">
<div class="container mt-4">
    <p>Error when processing job</p>
    <p>Message:</p>
    <p>{{ $message }}</p>
    <p>In file:</p>
    <p>{{ $file }}</p>
    <p>Failed at: {{ $failedAt }} UTC</p>
    <p>Please, call your developers with this message</p>
</div>
</body>
</html>