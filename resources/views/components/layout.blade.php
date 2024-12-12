<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Guru 2024</title>
    @vite('resources/css/app.css') {{-- Pastikan Vite sudah diatur untuk Tailwind CSS --}}
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-blue-500 text-white py-6">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold">Workshop Guru 2024</h1>
        <p class="text-lg mt-2">Tingkatkan keterampilan mengajar Anda bersama para ahli!</p>
    </div>
</header>

    {{ $slot }}

<!-- Footer -->
<footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto text-center">
        <p class="text-sm">&copy; 2024 Workshop Guru. All Rights Reserved.</p>
    </div>
</footer>

</body>
</html>