<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        window.onload = function() {
            // Cek apakah terdapat pesan sukses atau pesan error
            var successMessage = "{{ session('success') }}";
            var errorMessage = "{{ session('error') }}";

            if (successMessage) {
                alert(successMessage);
            }

            if (errorMessage) {
                alert(errorMessage);
            }
        };
    </script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    {{-- <div class="container mx-auto py-8">
    </div> --}}
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-semibold mb-4">Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300" value="{{ old('username') }}" required
                    autofocus>
            </div>
            <!-- Tambahkan field lainnya sesuai kebutuhan (misalnya: email, password, dll) -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Register</button>
            </div>
            <div class="mb-4 flex items-center justify-between">
                <span class="ml-2 text-sm text-gray-600">Already account?</span>
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Login</a>
            </div>
        </form>
    </div>
</body>

</html>
