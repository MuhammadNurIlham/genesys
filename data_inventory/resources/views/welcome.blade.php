<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-semibold mb-4 text-center">Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="username" name="username" id="username"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300">
            </div>
            <div class="mb-4 flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input type="checkbox" name="remember_me" id="remember_me"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Forgot your password?</a>
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Login</button>
            </div>
            <div class="mb-4 flex items-center justify-between">
                <span class="ml-2 text-sm text-gray-600">Don't have account?</span>
                <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Register</a>
            </div>
        </form>
    </div>
</body>

</html>
