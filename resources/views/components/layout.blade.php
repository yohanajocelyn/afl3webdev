<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Guru 2024</title>
    @vite('resources/css/app.css') {{-- Pastikan Vite sudah diatur untuk Tailwind CSS --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins';
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Header -->
<x-navigation></x-navigation>

    {{ $slot }}

<!-- Footer -->
<footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto text-center">
        <p class="text-sm">&copy; 2024 Workshop Guru. All Rights Reserved.</p>
    </div>
</footer>
081250205060
</body>
</html>