<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>
<body class="bg-cover bg-center h-screen" style="background-image: url('img/background.jpg');">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-black bg-opacity-20 backdrop-blur-lg rounded-lg p-8 shadow-lg w-96">
            <div class="text-center text-white text-2xl font-bold mb-4">Silahkan Login</div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-white">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full p-2 rounded-lg bg-transparent border border-white text-white focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-white">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                        class="w-full p-2 rounded-lg bg-transparent border border-white text-white focus:outline-none">
                </div>
                <button type="submit"
                    class="w-full bg-white text-black py-2 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
