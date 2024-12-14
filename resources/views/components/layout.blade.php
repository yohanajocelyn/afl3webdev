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
        <div class="container mx-auto flex justify-between">
            <!-- Centered Text -->
            <div class="text-center items-center justify-center flex-1">
                <h1 class="text-4xl font-bold">Workshop Guru 2024</h1>
                <p class="text-lg mt-2">Tingkatkan keterampilan mengajar Anda bersama para ahli!</p>
            </div>
            <div class="flex justify-end">
                <!-- Button Aligned Right -->
                @if ( $state == 'isLoggedOut')
                    <div class="flex items-center absolute py-5 font-bold text-white space-x-2">
                        <button class="bg-green-500 hover:text-green-500 hover:bg-transparent border-2 border-green-500 px-4 py-2 rounded-md hover:shadow-lg"
                        onclick="window.location.href = '/loginregister/?form=register'">
                            <span class="">register</span>
                        </button>
                        <button class="px-4 py-2 rounded-md bg-white text-blue-500 hover:bg-transparent hover:text-white border-2 hover:shadow-lg"
                        onclick="window.location.href = '/loginregister/?form=login'">
                            <span class="">login</span>
                        </button>
                    </div>
                @else
                    <div class="flex items-center">
                        {{-- Profile button or content here --}}
                    </div>
                @endif
            </div>
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
