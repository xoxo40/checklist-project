<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Assurez-vous d'avoir votre CSS ici -->
</head>
<body>
    <div class="container">
        @yield('content') <!-- Ici, le contenu des vues sera inséré -->
    </div>

    @livewireScripts
</body>
</html>
