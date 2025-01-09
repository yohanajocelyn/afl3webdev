<x-layout>
    <section class="bg-gray-100 flex flex-col">
        <div class="flex flex-col items-center px-auto py-10 md:flex-row md:pt-20 md:pb-16">
            {{-- Image --}}
            <div>
                <img src="" alt="workshop-image" class="w-[370px] h-[450px] object-cover rounded-md bg-blue-100">
            </div>
            {{-- details --}}
            <div class="flex flex-col ps-16 py-3 w-full h-[450px]">
                <p class="font-bold text-5xl">{{ $workshop->title }}</p>
                <p class="text-gray-600 py-4">{{ $workshop->description }}</p>
                <p>Tempat</p>
                <p>Tanggal dan Waktu</p>
                {{-- Register Button --}}
                @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                    <div class="mt-auto flex justify-end">
                        <a href="/registrations/?workshopId={{ $workshop->id }}">
                            <button class="bg-green-500 text-white px-4 py-2 rounded-md">
                                Registration
                            </button>
                        </a>
                    </div>
                @else
                    <div class="mt-auto flex justify-end">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Register
                        </button>
                    </div>
                @endif

            </div>
        </div>
        {{-- bottom part (the tugas / meets) --}}
        {{-- i think bisa di-loop --}}
        {{-- Workshop and Assignments buttons --}}
        <div class="flex justify-start space-x-6 mb-6">
            <button id="meetsButton"
                class="border-2 border-blue-500 text-blue-500 px-6 py-2 rounded-full hover:bg-blue-500 hover:text-white"
                onclick="toggleSection('meets')">
                Meets
            </button>
            <button id="assignmentsButton"
                class="border-2 border-purple-500 text-purple-500 px-6 py-2 rounded-full hover:bg-purple-600 hover:text-white"
                onclick="toggleSection('assignments')">
                Assignments
            </button>
            @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                <button id="teachersButton"
                    class="border-2 border-green-500 text-green-500 px-6 py-2 rounded-full hover:bg-green-600 hover:text-white"
                    onclick="toggleSection('teachers')">
                    Teachers
                </button>
            @endif
        </div>


        {{-- Meets Section --}}
        <div id="meetsSection" class="hidden">
            <h2 class="text-2xl font-bold mb-6">Meets</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pr-40">
                @if ($workshop->meets->isEmpty())
                    <div class="flex flex-col w-full h-40 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada data pertemuan.
                        </p>
                    </div>
                @else
                    @foreach ($workshop->meets as $meet)
                        <x-simple-card>
                            <x-slot:title>{{ $meet->location }}</x-slot:title>
                            <x-slot:date>{{ $meet->date }}</x-slot:title>
                        </x-simple-card>
                    @endforeach
                @endif
            </div>
        </div>


        {{-- Assignments Section --}}
        <div id="assignmentsSection" class="hidden">
            <h2 class="text-2xl font-bold mb-6">Assignments</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if ($workshop->assignments->isEmpty())
                    <div class="flex flex-col w-full h-40 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada data pertemuan.
                        </p>
                    </div>
                @else
                    @foreach ($workshop->assignments as $assignment)
                        <x-simple-card>
                            <x-slot:title>{{ $assignment->title }}</x-slot:title>
                            <x-slot:date>{{ $assignment->date }}</x-slot:title>
                        </x-simple-card>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Teachers Section --}}
        <div id="teachersSection" class="hidden">
            <h2 class="text-2xl font-bold mb-6">Teachers</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if ($registrations->isEmpty())
                    <div class="flex flex-col w-full h-40 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada data guru.
                        </p>
                    </div>
                @else
                    @foreach ($registrations as $registration)
                    <x-simple-card>
                        <x-slot:title>{{  $registration->teacher->name }}</x-slot:title>
                        <x-slot:date>{{  $registration->created_at->format('F j, Y') }}</x-slot:title>
                    </x-simple-card>
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
                document.getElementById('teachersButton').classList.remove('bg-green-500', 'text-white');
                document.getElementById('teachersButton').classList.add('border-2', 'border-green-500', 'text-green-500');

                // Show the selected section
                if (section === 'meets') {
                    document.getElementById('meetsSection').classList.remove('hidden');
                    document.getElementById('meetsButton').classList.add('bg-blue-500', 'text-white');
                    document.getElementById('meetsButton').classList.remove('border-2', 'border-blue-500', 'text-blue-500');
                } else if (section === 'assignments') {
                    document.getElementById('assignmentsSection').classList.remove('hidden');
                    document.getElementById('assignmentsButton').classList.add('bg-purple-500', 'text-white');
                    document.getElementById('assignmentsButton').classList.remove('border-2', 'border-purple-500',
                        'text-purple-500');
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
