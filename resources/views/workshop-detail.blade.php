<x-layout>
    <section class="bg-gray-100 flex flex-col">
        <!-- Workshop Details Header -->
        <div class="flex flex-col items-center px-4 py-10 md:flex-row md:px-10 md:pt-10 md:pb-16">
            <!-- Image -->
            <div class="self-start relative">
                <img src="{{ asset($workshop->imageURL) }}" alt="workshop-image"
                    class="max-w-[450px] max-h-[450px] w-full h-full object-scale-down rounded-md bg-blue-100">
                
                <!-- Registration Status Badge (Only shows when registered) -->
                @if (auth()->check() && auth()->user()->registrations()->where('workshop_id', $workshop->id)->exists())
                <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full font-medium">
                    Terdaftar
                </div>
                @endif
            </div>

            <!-- Details -->
            <div class="flex flex-col ps-0 md:ps-16 py-3 w-full h-auto md:h-auto mt-6 md:mt-0">
                <p class="font-bold text-3xl md:text-5xl text-center md:text-left">{{ $workshop->title }}</p>
                <p class="text-gray-600 py-4 text-center md:text-left">{{ $workshop->description }}</p>
                
                <div class="text-center pb-4 md:text-left flex flex-col md:flex-row">
                    <p class="">Tanggal Pelaksanaan: </p>
                    <p class="md:px-2">{{ $workshop['startDate']->format('F j, Y') }} -
                        {{ $workshop['endDate']->format('F j, Y') }}</p>
                </div>
                
                <!-- Price -->
                <div class="text-center md:text-left">
                    <p class="font-medium">Biaya Pendaftaran:</p>
                    <p class="text-lg">
                        @if ($workshop['price'] == 0)
                            Gratis
                        @else
                            Rp {{ number_format($workshop['price'], 0, ',', '.') }}
                        @endif
                    </p>
                </div>
                
                <!-- Register Button -->
                <div class="flex justify-center md:justify-start space-x-4 mb-3">
                    @if (auth()->check())
                        @if (!auth()->user()->registrations()->where('workshop_id', $workshop->id)->exists())
                            {{-- <button class="bg-gray-300 text-gray-600 px-6 py-2 rounded-md cursor-not-allowed">
                                Terdaftar
                            </button>
                        @else --}}
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition-all" onclick="togglePopUp(true)">
                                Daftar
                            </button>
                        @endif
                    @else
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition-all"
                            onclick="window.location.href = '/loginregister'">
                            Daftar
                        </button>
                    @endif
                </div>

                <!-- tab nav -->
                <div class="w-full mb-4">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <!-- tab buttons -->
                        <div class="flex border-b">
                            <button id="meetsButton" 
                                class="tab-btn active-tab flex-1 py-4 px-6 text-center font-medium focus:outline-none transition-all duration-200"
                                data-tab="meets">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Pertemuan
                            </button>
                            
                            @if (auth()->check() && auth()->user()->registrations()->where('workshop_id', $workshop->id)->exists())
                            <button id="assignmentsButton"
                                class="tab-btn flex-1 py-4 px-6 text-center font-medium focus:outline-none transition-all duration-200"
                                data-tab="assignments">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Tugas
                            </button>
                            @endif
                        </div>

                        <!-- tab meet -->
                        <div id="meets" class="tab-content p-6">
                            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-center md:text-left">Pertemuan</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($workshop->meets->isEmpty())
                                <div class="col-span-full flex flex-col w-full p-8 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-600 italic text-lg">
                                        Saat ini belum ada data pertemuan.
                                    </p>
                                </div>
                                @else
                                    @foreach ($workshop->meets as $meet)
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                                        <div class="p-1 bg-blue-500"></div>
                                        <div class="p-6">
                                            <h3 class="text-xl font-semibold mb-2 text-gray-800">{{ $meet->title }}</h3>
                                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $meet->date }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Assignments Tab Content -->
                        <div id="assignments" class="tab-content p-6 hidden">
                            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-center md:text-left">Tugas</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($workshop->assignments->isEmpty())
                                <div class="col-span-full flex flex-col w-full p-8 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-gray-600 italic text-lg">
                                        Saat ini belum ada tugas.
                                    </p>
                                </div>
                                @else
                                    @foreach ($workshop->assignments as $assignment)
                                    <a href="/assignment-detail/?assignmentId={{ $assignment->id }}">
                                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                                            <div class="p-1 bg-purple-500"></div>
                                            <div class="p-6">
                                                <h3 class="text-xl font-semibold mb-2 text-gray-800">{{ $assignment->title }}</h3>
                                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $assignment->date }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration popup -->
        <div id="registerPopUp" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white rounded-lg p-6 shadow-lg w-[90%] max-w-md">
                <h2 class="text-lg font-bold mb-4">Konfirmasi Registrasi</h2>
                <form action="{{ route('registerToWorkshop') }}" method="POST" enctype="multipart/form-data">
                    @if ($workshop['price'] != 0)
                        <p>Upload bukti pembayaran</p>
                        <input type="file" name="registrationProof" id="registrationProof" required class="my-2 w-full">
                    @endif
                    <p class="text-gray-600 mb-6">Apakah anda yakin ingin mendaftar ke workshop ini?</p>
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="cancelButton" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md transition-all" onclick="togglePopUp(false)">
                            Batal
                        </button>

                        @csrf
                        <input type="hidden" name="workshopId" id="workshopId" value="{{ $workshop->id }}">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-all">
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        // For the registration popup
        function togglePopUp(show) {
            const popup = document.getElementById('registerPopUp');
            if (show) {
                popup.classList.remove('hidden');
            } else {
                popup.classList.add('hidden');
            }
        }

        // Tab functionality
        document.addEventListener('DOMContentLoaded', () => {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');
                    
                    // Update active tab button
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active-tab');
                    });
                    button.classList.add('active-tab');
                    
                    // Show the selected tab content
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
    </script>

    <style>
        .active-tab {
            border-bottom: 3px solid #3b82f6;
            color: #3b82f6;
            font-weight: bold;
        }
        
        .tab-content {
            transition: all 0.3s ease-in-out;
        }
    </style>
</x-layout>