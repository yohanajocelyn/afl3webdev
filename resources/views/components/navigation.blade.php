{{-- <div class="flex flex-row items-center justify-between px-16 text-md">
    <div class="size-1/12"> --}}
        {{-- bisa juga {{ route('home') }} --}}
        {{-- <img src="{{ asset('images/logo-bebras.png') }}" alt="logo bebras">
    </div>
    <div class="flex flex-row w-[1/3] justify-center gap-x-8">
        <a href="">Home</a>
        <a href="">About Us</a>
        <a href="">Workshops</a>
    </div>
    <div class="flex flex-row gap-x-6">
        <button>
            <span>Log in</span>
        </button>
        <button>
            <span>Sign Up</span>
        </button>
    </div>
</div> --}}

<!-- resources/views/components/navbar.blade.php -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-4 
    transition-all duration-1000 ease-in-out 
    bg-white bg-opacity-100 
    transform translate-y-0">
    <!-- Logo Section (Left) -->
    <div class="flex items-center">
        <a href="{{ route('home') }}" class="flex flex-row items-center space-x-4">
            <img src="{{ asset('images/logo-uc.png') }}" alt="Logo UC" class="h-11 w-auto">
            <img src="{{ asset('images/logo-bebras-cropped.png') }}" alt="Logo Bebras" class="h-10 w-auto">
        </a>
    </div>

    <!-- Menu Section (Center) -->
    <div class="flex space-x-6">
        <a href="{{ route('home') }}" class="text-gray-800 hover:text-blue-600 transition duration-300">Home</a>
        <a href="{{ route('workshops') }}" class="text-gray-800 hover:text-blue-600 transition duration-300">Pelatihan</a>
        <a href="{{ route('about') }}" class="text-gray-800 hover:text-blue-600 transition duration-300">About Us</a>
    </div>

    <!-- Authentication Buttons (Right) -->
    <div class="flex space-x-4">
        @guest
            <a href="" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 transition duration-300">
                Log In
            </a>
            <a href="" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                Sign Up
            </a>
        @else
        <div class="flex space-x-4">
            @auth
                <form method="POST" action="">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-300">
                        Log Out
                    </button>
                </form>
                <a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-blue-600 transition duration-300">
                    <img src="" alt="Profile Picture">
                    <span>Username</span>
                </a>
            @endauth
        </div>
        @endguest
    </div>
</nav>