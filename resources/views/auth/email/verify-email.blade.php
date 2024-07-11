<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

    <style>
        .logo {
            text-align: center;
            color: black;
            font-size: 18px;
            text-decoration: none;
        }
    </style>
</head>
<body style="background-color: #e9ecef">
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4 fs-3">
                <a href="{{ config('app.url') }}" class="logo fs-4">
                    <strong>Job<span style="color: #f9322c;">avel</span></strong>
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
