<x-layout>
    <section class="bg-gray-100 flex flex-col">
        <div class="flex flex-col items-center px-4 py-10 md:flex-row md:px-10 md:pt-20 md:pb-16">
            {{-- Image --}}
            <div class="">
                <img src="" alt="workshop-image" class=" w-[400px] h-[450px] object-cover rounded-md bg-blue-100">
            </div>
            {{-- details --}}
            <div class="flex flex-col ps-0 md:ps-16 py-3 w-full h-auto md:h-[450px] mt-6 md:mt-0">
                <p class="font-bold text-3xl md:text-5xl text-center md:text-left">{{ $workshop->title }}</p>
                <p class="text-gray-600 py-4 text-center md:text-left">{{ $workshop->description }}</p>
                {{-- <p>Tempat: {{ $workshop->place }}</p> --}}
                <div class="text-center pb-4 md:text-left flex flex-col md:flex-row">
                    <p class="">Tanggal Pelaksanaan: </p>
                    <p class="md:px-2">{{ $workshop['startDate']->format('F j, Y') }} - {{ $workshop['endDate']->format('F j, Y') }}</p>
                </div>
                <p class="text-center md:text-left">Registration Fee:</p>
                <p class="text-center md:text-left pb-4">Rp {{ number_format($workshop['price'], 0, ',', '.') }}</p>
                {{-- Register Button --}}
                <div class="mt-auto flex justify-center md:justify-end">
                    @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                        <a href="/registrations/?workshopId={{ $workshop->id }}">
                            <button class="bg-green-500 text-white px-4 py-2 rounded-md">
                                Registration
                            </button>
                        </a>
                    @else
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Register
                        </button>
                    @endif
                </div>
            </div>
        </div>
        {{-- bottom part (the tugas / meets) --}}
        <div class="flex justify-center md:justify-start space-x-4 md:space-x-6 mb-6 px-4 md:px-10">
            <button id="meetsButton"
                class="border-2 border-blue-500 text-blue-500 px-4 py-2 rounded-full hover:bg-blue-500 hover:text-white"
                onclick="toggleSection('meets')">
                Meets
            </button>
            <button id="assignmentsButton"
                class="border-2 border-purple-500 text-purple-500 px-4 py-2 rounded-full hover:bg-purple-600 hover:text-white"
                onclick="toggleSection('assignments')">
                Assignments
            </button>
            @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                <button id="teachersButton"
                    class="border-2 border-green-500 text-green-500 px-4 py-2 rounded-full hover:bg-green-600 hover:text-white"
                    onclick="toggleSection('teachers')">
                    Teachers
                </button>
            @endif
        </div>


        {{-- Meets Section --}}
        <div id="meetsSection" class="hidden px-4 md:px-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-center md:text-left">Meets</h2>
                @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                    <a href="">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Meet</button>
                    </a>
                @endif
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @if ($workshop->meets->isEmpty())
                    <div class="flex flex-col w-full p-2 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada data pertemuan.
                        </p>
                    </div>
                @else
                    @foreach ($workshop->meets as $meet)
                    <a href="{{ route('mark-presence', ['meetId' => $meet->id]) }}">
                        <x-simple-card>
                            <x-slot:id>{{ $meet->id }}</x-slot:id>
                            <x-slot:title>{{ $meet->location }}</x-slot:title>
                            <x-slot:date>{{ $meet->date }}</x-slot:date>
                        </x-simple-card>
                    </a>
                    @endforeach
                @endif
            </div>
        </div>


        {{-- Assignments Section --}}
        <div id="assignmentsSection" class="hidden px-2 md:px-10">
            <h2 class="text-2xl font-bold mb-6 text-center md:text-left">Assignments</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @if ($workshop->assignments->isEmpty())
                    <div class="flex flex-col w-full h-40 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada data pertemuan.
                        </p>
                    </div>
                @else
                    @foreach ($workshop->assignments as $assignment)
                        <x-simple-card>
                            <x-slot:id>{{ $assignment->id }}</x-slot:id>
                            <x-slot:title>{{ $assignment->title }}</x-slot:title>
                            <x-slot:date>{{ $assignment->date }}</x-slot:title>
                        </x-simple-card>
                        
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Teachers Section --}}
        <div id="teachersSection" class="hidden px-4 md:px-10">
            <h2 class="text-2xl font-bold mb-6 text-center md:text-left">Teachers</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @if ($registrations->isEmpty())
                    <div class="flex flex-col w-full h-40 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada data guru.
                        </p>
                    </div>
                @else
                    @foreach ($registrations as $registration)
                    <x-teacher-card :teacher="$registration->teacher" :registration="$registration" />
                        {{-- <x-slot:title>{{  $registration->teacher->name }}</x-slot:title>
                        <x-slot:date>{{  $registration->regDate->format('F j, Y') }}</x-slot:date> --}}
                    {{-- </x-teacher-card> --}}
                    @endforeach
                @endif
            </div>
        </div>

        <script>
            function toggleSection(section) {
                // Hide both sections by default
                document.getElementById('meetsSection').classList.add('hidden');
                document.getElementById('assignmentsSection').classList.add('hidden');
                document.getElementById('teachersSection').classList.add('hidden');
                
                // Reset button styles biar transparent n ada border
                document.getElementById('meetsButton').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('meetsButton').classList.add('border-2', 'border-blue-500', 'text-blue-500');
                document.getElementById('assignmentsButton').classList.remove('bg-purple-500', 'text-white');
                document.getElementById('assignmentsButton').classList.add('border-2', 'border-purple-500', 'text-purple-500');
                @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                document.getElementById('teachersButton').classList.remove('bg-green-500', 'text-white');
                document.getElementById('teachersButton').classList.add('border-2', 'border-green-500', 'text-green-500');
                @endif
    
                // Show the selected section
                if (section === 'meets') {
                    document.getElementById('meetsSection').classList.remove('hidden');
                    document.getElementById('meetsButton').classList.add('bg-blue-500', 'text-white');
                    document.getElementById('meetsButton').classList.remove('border-2', 'border-blue-500', 'text-blue-500');
                } else if (section === 'assignments') {
                    document.getElementById('assignmentsSection').classList.remove('hidden');
                    document.getElementById('assignmentsButton').classList.add('bg-purple-500', 'text-white');
                    document.getElementById('assignmentsButton').classList.remove('border-2', 'border-purple-500', 'text-purple-500');
                } else if (section === 'teachers') {
                    document.getElementById('teachersSection').classList.remove('hidden');
                    document.getElementById('teachersButton').classList.add('bg-green-500', 'text-white');
                    document.getElementById('teachersButton').classList.remove('border-2', 'border-green-500',
                    'text-green-500');
                }
            }
    
            //workshops section by default
            toggleSection('meets');
        </script>

    </section>
</x-layout>