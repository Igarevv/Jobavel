<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm action</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
    </script>
    <style nonce="{{ csp_nonce() }}">
        .logo {
            text-align: center;
            color: black;
            font-size: 18px;
            text-decoration: none;
        }

        .red {
            color: #f9322c;
        }
    </style>
</head>
<body style="background-color: #e9ecef">
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4 fs-3">
                <a href="{{ config('app.url') }}" class="logo fs-4">
                    <strong>Job<span class="red">avel</span></strong>
                </a>
            </div>
            <div class="card p-4">
                <p class="fs-4 text-start text-dark">Verification code</p>
                <p class="text-start text-secondary">Hello. Your email has been added as a contact email. Copy this code
                    and paste it into specified field on the website.</p>
                <div class="text-center my-5">
                    <p class="fs-2 fw-bold text-center text-dark">{{ $code }}</p>
                </div>
                <p class="text-start text-secondary">If you have not performed such actions, leave message or contact
                    our support.</p>
                <p class="text-start text-secondary">Regards,</p>
                <p class="text-start text-secondary">Jobavel</p>
            </div>
            <p class="text-center mt-4 text-secondary">© 2024 Jobavel. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
