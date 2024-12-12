<<<<<<< Updated upstream
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
=======
<x-layout>
    <section class="bg-gray-100 py-16 px-32">
        <div class="container mx-auto flex flex-col lg:flex-row items-center lg:items-start lg:justify-between px-4">
            <!-- Left Column: Title and Description -->
            <div class="max-w-lg text-center lg:text-left">
                <h1 class="text-4xl font-extrabold text-gray-800 mb-6">Empowering Teachers Through Workshops</h1>
                <p class="text-lg text-gray-600 mb-6">
                    Join our hands-on workshops designed to help teachers enhance their skills, stay updated with modern teaching techniques, and create a positive impact in their classrooms.
                </p>
                <a href="#workshops" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium text-lg rounded-lg hover:bg-blue-700">
                    Explore Workshops
                </a>
            </div>
    
            <!-- Right Column: Main Image -->
            <div class="mt-8 lg:mt-0 lg:ml-12">
                <img src="/images/teacher-workshop-hero.jpg" alt="Teacher Workshop" class="w-full max-w-md rounded-lg shadow-lg">
            </div>
>>>>>>> Stashed changes
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-12">
        <div class="container mx-auto px-4">
            <!-- About Section -->
            <section class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-800">Apa yang Akan Anda Pelajari?</h2>
                <p class="mt-4 text-gray-600">
                    Workshop ini dirancang untuk membantu para guru meningkatkan kemampuan mengajar melalui sesi interaktif, materi terkini, dan diskusi kelompok.
                </p>
            </section>

            <!-- Workshop Details -->
            <section class="bg-white shadow-md rounded-lg p-8 mb-12">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Workshop</h3>
                <ul class="text-gray-700">
                    <li><strong>Tanggal:</strong> 15 Januari 2024</li>
                    <li><strong>Waktu:</strong> 09:00 - 16:00</li>
                    <li><strong>Lokasi:</strong> Aula Sekolah XYZ</li>
                    <li><strong>Topik:</strong> Inovasi dalam Pengajaran di Era Digital</li>
                </ul>
            </section>

            <!-- Call to Action -->
            <section class="text-center">
                <a href="/daftar" 
                   class="bg-blue-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-blue-600">
                    Daftar Sekarang
                </a>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; 2024 Workshop Guru. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
