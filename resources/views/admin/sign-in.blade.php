<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    @vite(['resources/assets/css/admin.css', 'resources/assets/js/admin.js'])
    <style>
        .login-container {
            max-width: 600px;
            width: 150%;
            padding: 2rem;
        }

        .background-red {
            background-color: #f9322c;
            color: white;
        }

        .text-red {
            color: #f9322c;
        }
    </style>
</head>
<body>
<section class="bg-gray-50 dark:bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <a href="#" class="flex items-center text-2xl font-semibold text-gray-900 dark:text-white m-10">
            Job<span class="text-red">avel</span>
            <span class="pl-1">Admin</span>
        </a>
        <div class="w-full login-container bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
            <div class="p-8 space-y-6">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                <form class="space-y-6" action="{{ route('admin.sign-in') }}" method="POST">
                    @csrf
                    <div class="mb-custom-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                            email</label>
                        <input type="email" name="email" id="email"
                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="" required="">
                    </div>
                    <div class="mb-2">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                               class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required="">
                    </div>
                    <button type="submit"
                            class="w-full mb-custom-5 background-red text-dark bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Sign in
                    </button>
                </form>
                <div class="text-center">
                    @error('email')
                    <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
