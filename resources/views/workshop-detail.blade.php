<x-layout>
    <section class="bg-gray-100 flex flex-col">
        <div class="flex flex-col items-center px-4 py-10 md:flex-row md:px-10 md:pt-20 md:pb-16">
            {{-- Image --}}
            <div class="self-start">
                <img src="{{ asset($workshop->imageURL) }}" alt="workshop-image"
                    class="max-w-[450px] max-h-[450px] w-full h-full object-scale-down rounded-md bg-blue-100">
            </div>
            {{-- details --}}
            <div class="flex flex-col ps-0 md:ps-16 py-3 w-full h-auto md:h-[450px] mt-6 md:mt-0">
                <p class="font-bold text-3xl md:text-5xl text-center md:text-left">{{ $workshop->title }}</p>
                <p class="text-gray-600 py-4 text-center md:text-left">{{ $workshop->description }}</p>
                {{-- <p>Tempat: {{ $workshop->place }}</p> --}}
                <div class="text-center pb-4 md:text-left flex flex-col md:flex-row">
                    <p class="">Tanggal Pelaksanaan: </p>
                    <p class="md:px-2">{{ $workshop['startDate']->format('F j, Y') }} -
                        {{ $workshop['endDate']->format('F j, Y') }}</p>
                </div>
                <p class="text-center md:text-left">Biaya Pendaftaran:</p>
                <p class="text-center md:text-left pb-4">
                    @if ($workshop['price'] == 0)
                        Gratis
                    @else
                        Rp {{ number_format($workshop['price'], 0, ',', '.') }}
                </p>
                @endif
                {{-- Register Button --}}
                <div class="mt-auto flex justify-center md:justify-start space-x-4">

                    @if (auth()->check())
                        @if (auth()->user()->registrations()->where('workshop_id', $workshop->id)->exists())
                            <button class="bg-gray-300 text-gray-600 px-4 py-2 rounded-md">
                                Terdaftar
                            </button>
                        @else
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="togglePopUp(true)">
                                Daftar
                            </button>
                        @endif
                    @else
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-md"
                            onclick="window.location.href = '/loginregister'">
                            Daftar
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- registration popup --}}
        <div id="registerPopUp" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg p-6 shadow-lg w-[90%] max-w-md">
                <h2 class="text-lg font-bold mb-4">Konfirmasi Registrasi</h2>
                <form action="{{ route('registerToWorkshop') }}" method="POST" enctype="multipart/form-data">
                    @if ($workshop['price'] != 0)
                        <p>Upload bukti pembayaran</p>
                        <input type="file" name="registrationProof" id="registrationProof" required>
                    @endif
                    <p class="text-gray-600 mb-6">Apakah anda yakin ingin mendaftar ke workshop ini?</p>
                    <div class="flex justify-end space-x-4">
                        <button id="cancelButton" class="bg-gray-300 px-4 py-2 rounded-md" onclick="togglePopUp(false)">
                            Batal
                        </button>

                        @csrf
                        <input type="hidden" name="workshopId" id="workshopId" value="{{ $workshop->id }}">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Konfirmasi
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
                    @if (auth()->check() && auth()->user()->registrations->where('workshop_id', $workshop->id)->isNotEmpty()) toggleSection('assignments') @endif
                ">
                Tugas
            </button>
        </div>


        {{-- Meets Section --}}
        <div id="meetsSection" class="hidden px-4 md:px-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-center md:text-left">Pertemuan</h2>
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
                        <x-simple-card>
                            <x-slot:title>{{ $meet->title }}</x-slot:title>
                            <x-slot:date>{{ $meet->date }}</x-slot:date>
                        </x-simple-card>
                    @endforeach
                @endif
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
                        <a href="/assignment-detail/?assignmentId={{ $assignment->id }}">
                            <x-simple-card>
                                <x-slot:title>{{ $assignment->title }}</x-slot:title>
                                <x-slot:date>{{ $assignment->date }}</x-slot:title>
                            </x-simple-card>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

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
