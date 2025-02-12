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
        <a href="{{ route('home') }}" class="text-gray-800 hover:text-blue-600 transition duration-300">Home</a>
        <a href="{{ route('home') }}#workshops" class="text-gray-800 hover:text-blue-600 transition duration-300">Pelatihan</a>
        <a href="" class="text-gray-800 hover:text-blue-600 transition duration-300">About Us</a>
        @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
            <div class="relative group">
                <!-- Button -->
                <button class="text-gray-800 hover:text-blue-600 transition duration-300 flex items-center">
                    Admin
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            
                <!-- Dropdown -->
                <div class="absolute top-4 hidden group-hover:block flex-col bg-white shadow-lg rounded-md mt-2 py-2 w-48 right-0 z-50">
                    <a href="{{ route('workshop-upload') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition duration-300">
                        Add Workshop
                    </a>
                    <a href="" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition duration-300">
                        Manage Workshops
                    </a>
                    <a href="{{ route('registrations') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition duration-300">
                        View Registrations
                    </a>
                    <a href="{{ route('view-teachers') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition duration-300">
                        View Teachers
                    </a>
                    <a href="{{ route('view-schools') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition duration-300">
                        View Schools
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Authentication Buttons (Right) -->
    <div class="flex space-x-4">
        @guest
            <button class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 transition duration-300"
            onclick="window.location.href = '/loginregister/?form=login'">
                Log In
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300"
            onclick="window.location.href = '/loginregister/?form=register'">
                Sign Up
            </button>
        @else
        <div class="flex space-x-4">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-300">
                        Log Out
                    </button>
                </form>
                <a href="/teacherprofile/?teacherId={{ auth()->user()->id }}" class="text-gray-800 hover:text-blue-600 transition duration-300 flex flex-row justify-center items-center">
                    <img src="{{ asset(auth()->guard('teacher')->user()->pfpURL) }}" alt="Profile Picture" class="w-8 h-8 rounded-full mr-2">
                    <span>{{ auth()->user()->name }}</span>
                </a>
            @endauth
        </div>
        @endguest
    </div>
</nav>