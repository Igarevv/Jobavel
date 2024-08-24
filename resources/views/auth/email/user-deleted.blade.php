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
                <p class="fs-4 text-start">Dear, Jobavel User </p>
                <p class="text-start text-secondary">You received this message because your account on our web-service
                    was temporarily deleted.</p>
                <p class="text-start text-secondary">We have decided to delete your account because you have not
                    verified
                    your email address. According to <a href="#" class="link-danger">our rules</a> this means, that your
                    account is
                    bot-like.</p>
                <p class="text-start text-secondary"><b>Please note! </b>Your account <b> is not deleted forever</b>. To
                    restore your account, please create ticket <a href="#" class="link-danger">to our support</a> team
                    about this situation.
                </p>
                <p class="text-start text-secondary">Regards,</p>
                <hr class="mt-1 mb-1"/>
                <p class="text-start text-secondary">Jobavel</p>
            </div>
            <p class="text-center mt-4 text-secondary">© 2024 Jobavel. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>