<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
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

        .background-white-darker {
            background-color: #e9ecef;
        }

        .red {
            color: #f9322c;
        }
    </style>
</head>
<body class="background-white-darker">
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4 fs-3">
                <a href="{{ config('app.url') }}" class="logo fs-4">
                    <strong>Job<span class="red">avel</span></strong>
                </a>
            </div>
            <div class="card p-4">
                <p class="fs-4 text-start">Hello!</p>
                <p class="text-start text-secondary">Please click the button below to verify your email address.</p>
                <div class="text-center my-5">
                    <a href="{{ $verificationUrl }}" class="btn btn-dark btn-lg text-white">Confirm
                        email address</a>
                </div>
                <p class="text-start text-secondary">If you did not create an account, no further action is
                    required.</p>
                <p class="text-start text-secondary">Regards,</p>
                <p class="text-start text-secondary">Jobavel</p>
                <hr class="mt-1 mb-1"/>
                <p class="text-start text-secondary text-secondary">If you're having trouble clicking the "Verify Email
                    Address" button, <a href="{{ $verificationUrl }}">click here</a></p>
            </div>
            <p class="text-center mt-4 text-secondary">© 2024 Jobavel. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
