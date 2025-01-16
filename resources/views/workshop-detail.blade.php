<x-layout>
    <section class="bg-gray-100 flex flex-col">
        <div class="flex flex-col items-center px-4 py-10 md:flex-row md:px-10 md:pt-20 md:pb-16">
            {{-- Image --}}
            <div class="self-start">
                <img src="{{ asset($workshop->imageURL) }}" alt="workshop-image" class="max-w-[450px] max-h-[450px] w-full h-full object-scale-down rounded-md bg-blue-100">
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
                <p class="text-center md:text-left">Biaya Pendaftaran:</p>
                <p class="text-center md:text-left pb-4">Rp {{ number_format($workshop['price'], 0, ',', '.') }}</p>
                {{-- Register Button --}}
                <div class="mt-auto flex justify-center md:justify-start space-x-4">
                    @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                        <!-- Peserta Terdaftar Button -->
                        <a href="/registrations/?workshopId={{ $workshop->id }}">
                            <button class="bg-green-500 text-white px-4 py-2 rounded-md">
                                Peserta Terdaftar
                            </button>
                        </a>
                        <!--open workshop button -->
                        <form action="{{ route('open-workshop') }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input id="workshopId" name="workshopId" type="hidden" value="{{ $workshop['id'] }}">
                            <button type="submit" class="
                                @if ($workshop['isOpen'])
                                    bg-red-500
                                @else
                                    bg-yellow-500
                                @endif
                             text-white px-4 py-2 rounded-md">
                                @if ($workshop['isOpen'])
                                    Tutup Workshop
                                @else
                                    Buka Workshop
                                @endif
                            </button>
                        </form>
                    @else
                        @if (auth()->check())
                            @if (auth()->user()->registrations()->where('workshop_id', $workshop->id)->exists())
                                <button class="bg-gray-300 text-gray-600 px-4 py-2 rounded-md">
                                    Registered
                                </button>
                            @else
                                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="togglePopUp(true)">
                                    Register
                                </button>
                            @endif
                        @else
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="window.location.href = '/loginregister'">
                                Register
                            </button>
                        @endif
                    @endif
                </div>                
            </div>
        </div>

        {{-- registration popup --}}
        <div id="registerPopUp" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg p-6 shadow-lg w-[90%] max-w-md">
                <h2 class="text-lg font-bold mb-4">Confirm Registration</h2>
                <form action="{{ route('registerToWorkshop') }}" method="POST" enctype="multipart/form-data">
                @if ($workshop['price'] != 0)
                    <p>Upload file here</p>
                    <input type="file" name="registrationProof" id="registrationProof" required>
                @endif
                <p class="text-gray-600 mb-6">Are you sure you want to register for this workshop?</p>
                <div class="flex justify-end space-x-4">
                    <button id="cancelButton" class="bg-gray-300 px-4 py-2 rounded-md" onclick="togglePopUp(false)">
                        Cancel
                    </button>
                    
                        @csrf
                        <input type="hidden" name="workshopId" id="workshopId" value="{{ $workshop->id }}">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- bottom part (the tugas / meets) --}}
        <div class="flex justify-center md:justify-start space-x-4 md:space-x-6 md:mt-10 mb-6 px-4 md:px-10">
            <button id="meetsButton"
                class="border-2 border-blue-500 text-blue-500 px-4 py-2 rounded-full hover:bg-blue-500 hover:text-white"
                onclick="toggleSection('meets')">
                Pertemuan
            </button>
            <button id="assignmentsButton"
                class="border-2 border-purple-500 text-purple-500 px-4 py-2 rounded-full hover:bg-purple-600 hover:text-white"
                onclick="
                    @if (auth()->check() && (auth()->user()->registrations->where('workshop_id', $workshop->id)->isNotEmpty() || auth()->user()->role === \App\Enums\Role::Admin))
                        toggleSection('assignments')
                    @endif
                ">
                Tugas
            </button>
            @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                
                <a href="
                    @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                        {{ route('workshop-progress', ['workshopId' => $workshop->id]) }}
                    @endif
                ">
                    <button id="pesertaButton"
                        class="border-2 border-green-500 text-green-500 px-4 py-2 rounded-full hover:bg-green-600 hover:text-white"
                        onclick="">
                        Peserta
                    </button>
                </a>
            @endif
        </div>


        {{-- Meets Section --}}
        <div id="meetsSection" class="hidden px-4 md:px-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-center md:text-left">Pertemuan</h2>
                @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md", onclick="toggleAddMeetingPopUp(true)">Tambahkan Pertemuan</button>
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
                    <a href="
                    @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                        {{ route('mark-presence', ['meetId' => $meet->id]) }}
                    @endif
                    ">
                        <x-simple-card>
                            <x-slot:title>{{ $meet->title }}</x-slot:title>
                            <x-slot:date>{{ $meet->date }}</x-slot:date>
                        </x-simple-card>
                    </a>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- meeting popup -->
        <div id="addMeetingPopUp" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white rounded-lg p-6 shadow-lg w-[90%] max-w-md">
                <h2 class="text-lg font-bold mb-4">Tambah Pertemuan</h2>
                <form action="{{ route('create-meet') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-bold mb-2">Judul:</label>
                        <input type="text" id="title" name="title" class="border rounded-lg px-3 py-2 w-full" placeholder="Masukkan judul" required>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 font-bold mb-2">Tanggal:</label>
                        <input type="date" id="date" name="date" class="border rounded-lg px-3 py-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi:</label>
                        <input type="text" id="description" name="description" class="border rounded-lg px-3 py-2 w-full" placeholder="Masukkan deskripsi" required>
                    </div>
                    <input id="workshopId" name="workshopId" type="hidden" value="{{ $workshop->id }}">
                    <div class="flex justify-end space-x-4">
                        <button type="button" class="bg-gray-300 px-4 py-2 rounded-md" onclick="toggleAddMeetingPopUp(false)">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Assignments Section --}}
        <div id="assignmentsSection" class="hidden px-2 md:px-10">
            <h2 class="text-2xl font-bold mb-6 text-center md:text-left">Tugas</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @if ($workshop->assignments->isEmpty())
                    <div class="flex flex-col w-full h-40 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada tugas.
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

        {{-- Peserta Section --}}
        {{-- <div id="pesertaSection" class="hidden px-4 md:px-10">
            <h2 class="text-2xl font-bold mb-6 text-center md:text-left">Peserta</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @if ($registrations->isEmpty())
                    <div class="flex flex-col w-full h-40 items-center justify-center">
                        <p class="text-gray-600 italic">
                            Saat ini belum ada data peserta.
                        </p>
                    </div>
                @else
                    @foreach ($registrations as $registration)
                    <x-teacher-card :teacher="$registration->teacher" :registration="$registration" /> --}}
                        {{-- <x-slot:title>{{  $registration->teacher->name }}</x-slot:title>
                        <x-slot:date>{{  $registration->regDate->format('F j, Y') }}</x-slot:date> --}}
                    {{-- </x-teacher-card> --}}
                    {{-- @endforeach
                @endif
            </div>
        </div> --}}

        <script>
            //for the registration popup
            document.getElementById('registerPopUp').classList.add('hidden')

            function togglePopUp(show) {
                const popup = document.getElementById('registerPopUp');
                if (show) {
                    popup.classList.remove('hidden');
                } else {
                    popup.classList.add('hidden');
                }
            }
            document.getElementById('addMeetingPopUp').classList.add('hidden')

            function toggleAddMeetingPopUp(show) {
                const popup = document.getElementById('addMeetingPopUp');
                if (show) {
                    popup.classList.remove('hidden');
                } else {
                    popup.classList.add('hidden');
                }
            }

            function toggleSection(section) {
                document.getElementById('meetsSection').classList.add('hidden');
                document.getElementById('assignmentsSection').classList.add('hidden');
                // document.getElementById('pesertaSection').classList.add('hidden');
                
                //Reset button styles biar transparent n ada border
                document.getElementById('meetsButton').classList.remove('bg-blue-500', 'text-white');
                document.getElementById('meetsButton').classList.add('border-2', 'border-blue-500', 'text-blue-500');
                document.getElementById('assignmentsButton').classList.remove('bg-purple-500', 'text-white');
                document.getElementById('assignmentsButton').classList.add('border-2', 'border-purple-500', 'text-purple-500');
                @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                // document.getElementById('pesertaButton').classList.remove('bg-green-500', 'text-white');
                // document.getElementById('pesertaButton').classList.add('border-2', 'border-green-500', 'text-green-500');
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
                } 
                // else if (section === 'peserta') {
                //     document.getElementById('pesertaSection').classList.remove('hidden');
                //     document.getElementById('pesertaButton').classList.add('bg-green-500', 'text-white');
                //     document.getElementById('pesertaButton').classList.remove('border-2', 'border-green-500',
                //     'text-green-500');
                // }
            }
    
            //workshops section by default
            toggleSection('meets');
        </script>

    </section>
</x-layout>