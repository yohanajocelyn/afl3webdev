<x-layout>
    {{-- <section class="bg-gray-100 py-16">
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
        </div>
    </section> --}}

    {{-- hero section --}}
    <section>
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row items-center">
            <!-- Left Side - Text Content -->
            <div class="w-full md:w-[60%] md:pr-12 text-left">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <span class="text-[#5271ff]">Biro Bebras</span>
                    <span class="bg-gradient-to-r from-[#f08101] to-[#faad17] bg-clip-text text-transparent">Universitas Ciputra:</span>
                    <span>Pelatihan Guru</span>
                </h1>
                <p class="text-md w-[75%] text-gray-600 mb-8 leading-relaxed">
                    Biro Bebras menyediakan pelatihan dan program pengembangan profesional untuk guru-guru di bidang Computational Thinking dan Informatika. 
                    Program ini dirancang untuk membantu guru-guru K12 mengembangkan pemahaman tentang konsep dan teknik dari ilmu komputer, serta memberikan ide 
                    dan sumber daya untuk mengajarkan Computational Thinking kepada siswa mereka. Dengan memberikan pelatihan dan sumber daya kepada guru-guru K12, 
                    Biro Bebras berharap dapat meningkatkan kualitas pendidikan di bidang teknologi dan mempersiapkan siswa-siswa untuk masa depan yang semakin tergantung pada teknologi.
                </p>
                
                <!-- Call to Action Buttons -->
                <div class="flex space-x-4">
                    <a href="{{ route('workshops') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 shadow-md">
                        Lihat Pelatihan
                    </a>
                    <a href="" class="px-6 py-3 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition duration-300 shadow-md">
                        Sign Up
                    </a>
                </div>
            </div>

            <!-- Right Side - Image -->
            <div class="w-full md:w-[40%] mt-10 md:mt-0">
                <img 
                    src="{{ asset('images/placeholder-img.jpg') }}" 
                    alt="stock photo" 
                    class="w-full h-auto rounded-xl shadow-2xl object-cover"
                >
            </div>
        </div>
    </section>

    <x-divider></x-divider>

    <!-- Main Content -->
    <main class="pt-8 pb-12">
        <div class="flex flex-col mx-auto px-4">
            <!-- About Section -->
            <section class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-800">Pelatihan</h2>
                <p class="mt-4 text-gray-600">
                    Pelatihan ini dirancang untuk membantu para guru meningkatkan kemampuan mengajar melalui sesi interaktif, materi terkini, dan diskusi kelompok.
                </p>
            </section>

            <section class="mb-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @for ($i = 0; $i<6; $i++)
                        <x-card></x-card>
                    @endfor
                </div>
            </section>
        </div>

        <x-divider></x-divider>

        <div>
            <section class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-800">Upcoming Events</h2>
                
            </section>
        </div>
    </main>
</x-layout>

    
</x-layout>

    
