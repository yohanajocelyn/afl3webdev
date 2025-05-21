<x-layout>
    <section class=" min-h-screen py-16">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Page Header -->
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Pelatihan Saya</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Pantau dan kelola semua pelatihan dan penugasan yang
                    Anda ikuti dalam satu tempat</p>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-10">
                <!-- Tabs Navigation -->
                <div class="flex border-b">
                    <button
                        class="tab-btn active-tab flex-1 py-4 px-6 text-center font-medium focus:outline-none transition-all duration-200"
                        data-tab="workshops">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Pelatihan
                    </button>
                    <button
                        class="tab-btn flex-1 py-4 px-6 text-center font-medium focus:outline-none transition-all duration-200"
                        data-tab="assignments">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Penugasan
                    </button>
                </div>

                <!-- Workshops Tab Content -->
                <div id="workshops" class="tab-content p-6">
                    <!-- Category Selection -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        <button
                            class="category-btn active-category px-5 py-2 rounded-full text-sm font-medium focus:outline-none transition-all duration-200 bg-blue-600 text-white"
                            data-category="berjalan">
                            Pelatihan Berjalan
                        </button>
                        <button
                            class="category-btn px-5 py-2 rounded-full text-sm font-medium focus:outline-none transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-yellow-500 hover:text-white"
                            data-category="menunggu">
                            Menunggu Persetujuan
                        </button>
                        <button
                            class="category-btn px-5 py-2 rounded-full text-sm font-medium focus:outline-none transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-500 hover:text-white"
                            data-category="riwayat">
                            Riwayat Pelatihan
                        </button>
                    </div>

                    <!-- Workshop Cards -->
                    @php
                        $workshopsByStatus = [
                            'berjalan' => $joinedWorkshops,
                            'menunggu' => $pendingWorkshops,
                            'riwayat' => $historyWorkshops,
                        ];
                    @endphp

                    @foreach ($workshopsByStatus as $status => $workshops)
                        <div id="{{ $status }}-content"
                            class="category-content {{ $status === 'berjalan' ? 'block' : 'hidden' }}">
                            @if (count($workshops) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($workshops as $registration)
                                        <div
                                            class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                                            <div
                                                class="p-1 {{ $status === 'berjalan' ? 'bg-green-500' : ($status === 'menunggu' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                                            </div>
                                            <div class="p-6">
                                                <h3 class="text-xl font-semibold mb-2 text-gray-800">
                                                    {{ $registration->workshop->title }}</h3>
                                                <p class="text-gray-600 mb-4 line-clamp-2">
                                                    {{ $registration->workshop->description ?? 'Tidak ada deskripsi tersedia.' }}
                                                </p>
                                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>Terdaftar:
                                                        {{ $registration->created_at->format('d M Y') }}</span>
                                                </div>
                                                <a href="{{ isset($registration->workshop->id) ? route('workshop-detail', ['id' => $registration->workshop->id]) : '#' }}"
                                                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                                                    Detail Pelatihan
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">Tidak ada pelatihan yang ditemukan.</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Assignments Tab Content -->
                <div id="assignments" class="tab-content p-6 hidden">
                    <!-- Category Selection -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        <button
                            class="category-btn active-category px-5 py-2 rounded-full text-sm font-medium focus:outline-none transition-all duration-200 bg-purple-600 text-white"
                            data-category="belum-dikerjakan">
                            Belum Dikerjakan
                        </button>
                        <button
                            class="category-btn px-5 py-2 rounded-full text-sm font-medium focus:outline-none transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-orange-500 hover:text-white"
                            data-category="menunggu-persetujuan">
                            Menunggu Persetujuan
                        </button>
                        <button
                            class="category-btn px-5 py-2 rounded-full text-sm font-medium focus:outline-none transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-green-500 hover:text-white"
                            data-category="disetujui">
                            Disetujui
                        </button>
                    </div>

                    <!-- Assignment Cards -->
                    @php
                        $assignmentsByStatus = [
                            'belum-dikerjakan' => $ongoingAssignments,
                            'menunggu-persetujuan' => $doneAssignments,
                            'disetujui' => $approvedAssignments,
                        ];
                    @endphp

                    @foreach ($assignmentsByStatus as $status => $assignments)
                        <div id="{{ $status }}-content"
                            class="category-content {{ $status === 'belum-dikerjakan' ? 'block' : 'hidden' }}">
                            @if (count($assignments) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($assignments as $assignment)
                                        <div
                                            class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                                            <div
                                                class="p-1 {{ $status === 'belum-dikerjakan' ? 'bg-purple-500' : ($status === 'menunggu-persetujuan' ? 'bg-orange-500' : 'bg-green-500') }}">
                                            </div>
                                            <div class="p-6">
                                                <h3 class="text-xl font-semibold mb-2 text-gray-800">
                                                    {{ $assignment->title }}</h3>
                                                <p class="text-gray-600 mb-4 line-clamp-2">
                                                    {{ $assignment->description ?? 'Tidak ada deskripsi tersedia.' }}
                                                </p>
                                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>Ditugaskan:
                                                        {{ $assignment->created_at->format('d M Y') }}</span>
                                                </div>
                                                <a href="{{ isset($assignment->id) ? route('assignment-detail', ['assignmentId' => $assignment->id]) : '#' }}"
                                                    class="inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors duration-200">
                                                    Detail Tugas
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">Tidak ada penugasan yang ditemukan.</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tab switching
            const tabs = document.querySelectorAll('.tab-btn');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.getAttribute('data-tab');

                    // Update active tab styling
                    tabs.forEach(t => t.classList.remove('active-tab'));
                    tab.classList.add('active-tab');

                    // Show/hide content
                    contents.forEach(content => {
                        content.id === target ?
                            content.classList.remove('hidden') :
                            content.classList.add('hidden');
                    });
                });
            });

            // Category switching for workshops
            const workshopCategoryBtns = document.querySelectorAll('#workshops .category-btn');
            const workshopCategoryContents = document.querySelectorAll('#workshops .category-content');

            workshopCategoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-category');

                    // Reset all buttons to default state
                    workshopCategoryBtns.forEach(b => {
                        b.classList.remove('active-category', 'bg-blue-600',
                            'bg-yellow-500', 'bg-gray-500', 'text-white');
                        b.classList.add('bg-gray-200', 'text-gray-700');
                    });

                    // Add active-category class and apply specific color based on category
                    btn.classList.add('active-category', 'text-white');
                    btn.classList.remove('bg-gray-200', 'text-gray-700');

                    if (target === 'berjalan') {
                        btn.classList.add('bg-blue-600');
                    } else if (target === 'menunggu') {
                        btn.classList.add('bg-yellow-500');
                    } else if (target === 'riwayat') {
                        btn.classList.add('bg-gray-500');
                    }

                    // Show/hide content
                    workshopCategoryContents.forEach(content => {
                        content.id === `${target}-content` ?
                            content.classList.remove('hidden') :
                            content.classList.add('hidden');
                    });
                });
            });

            // Category switching for assignments
            const assignmentCategoryBtns = document.querySelectorAll('#assignments .category-btn');
            const assignmentCategoryContents = document.querySelectorAll('#assignments .category-content');

            assignmentCategoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-category');

                    // Reset all buttons to default state
                    assignmentCategoryBtns.forEach(b => {
                        b.classList.remove('active-category', 'bg-purple-600',
                            'bg-orange-500', 'bg-green-500', 'text-white');
                        b.classList.add('bg-gray-200', 'text-gray-700');
                    });

                    // Add active-category class and apply specific color based on category
                    btn.classList.add('active-category', 'text-white');
                    btn.classList.remove('bg-gray-200', 'text-gray-700');

                    if (target === 'belum-dikerjakan') {
                        btn.classList.add('bg-purple-600');
                    } else if (target === 'menunggu-persetujuan') {
                        btn.classList.add('bg-orange-500');
                    } else if (target === 'disetujui') {
                        btn.classList.add('bg-green-500');
                    }

                    // Show/hide content
                    assignmentCategoryContents.forEach(content => {
                        content.id === `${target}-content` ?
                            content.classList.remove('hidden') :
                            content.classList.add('hidden');
                    });
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

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Optional animations for smoother transitions */
        .tab-content {
            transition: all 0.3s ease-in-out;
        }

        .category-content {
            transition: all 0.3s ease-in-out;
        }
    </style>
</x-layout>
