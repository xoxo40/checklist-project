<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="flex h-screen bg-gray-100">
    <div class="flex flex-col justify-center w-full max-w-md px-8 py-6 mx-auto bg-white shadow-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Connectez-vous à votre compte</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Adresse e-mail</label>
                <input type="email" id="email" name="email" required class="w-full px-3 py-2 mt-1 border rounded-lg">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required class="w-full px-3 py-2 mt-1 border rounded-lg">
                </div>
            </div>
            <div class="flex items-center mb-4">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-primary">
                <label for="remember" class="ml-2 text-sm text-gray-600">Se souvenir de moi</label>
            </div>
            <button type="submit" class="w-full px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                Connexion
            </button>
        </form>
    </div>
    <div class="flex items-center justify-center w-full bg-cover bg-center" style="background-image: url('path/to/your/image.jpg');">
        <div class="text-white text-center">
            <p>Photo by Joshua Earle on Unsplash</p>
        </div>
    </div>
</body>
</html>
