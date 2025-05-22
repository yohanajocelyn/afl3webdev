@php
    use Illuminate\Support\Str;
@endphp
<nav id="navbar"
    class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-4 
    transition-all duration-1000 ease-in-out 
    bg-white bg-opacity-100 
    transform translate-y-0">
    <!-- Logo Section (Left) -->
    <div class="flex items-center">
        <div class="flex flex-row items-center space-x-4">
            <a href="https://ciputra.ac.id">
                <img src="{{ asset('images/logo-uc.png') }}" alt="Logo UC" class="h-11 w-auto">
            </a>
            <a href="https://bebras.uc.ac.id">
                <img src="{{ asset('images/logo-bebras-cropped.png') }}" alt="Logo Bebras" class="h-10 w-auto">
            </a>
        </div>
    </div>

    <!-- Menu Section (Center) -->
    <div class="flex space-x-6">
        <a href="{{ route('home') }}" class="text-gray-800 hover:text-blue-600 transition duration-300">Beranda</a>
        <a href="{{ route('home') }}#workshops"
            class="text-gray-800 hover:text-blue-600 transition duration-300">Pelatihan</a>
        @if(auth()->user())
        <a href="{{ route('my-courses') }}" class="text-gray-800 hover:text-blue-600 transition duration-300">Aktivitas
            Saya</a>
        @endif

    </div>

    <!-- Authentication Buttons (Right) -->
    <div class="flex space-x-4">
        @guest
            <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 transition duration-300"
                onclick="window.location.href = '/loginregister/?form=login'">
                Masuk
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300"
                onclick="window.location.href = '/loginregister/?form=register'">
                Daftar
            </button>
        @else
            <div class="flex space-x-4">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-300">
                            Log Out
                        </button>
                    </form>

                    <a href="/teacherprofile/?teacherId={{ auth()->user()->id }}"
                        class="text-gray-800 hover:text-blue-600 transition duration-300 flex flex-row justify-center items-center">
                        <img src="{{ asset('storage/profile_pictures/defaultProfilePicture.jpg') }}" alt="Profile Picture"
                            class="w-8 h-8 rounded-full mr-2">
                        <span>{{ Str::limit(auth()->user()->name, 5, '...') }}</span>
                    </a>

                @endauth
            </div>
        @endguest
    </div>
</nav>
