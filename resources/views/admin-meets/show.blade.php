<x-admin-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Meet Details</h2>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Workshop Title</p>
                <p class="text-lg font-semibold text-gray-800">{{ $meet->workshop->title }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Meet Title</p>
                <p class="text-lg font-semibold text-gray-800">{{ $meet->title }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Date</p>
                <p class="text-lg text-gray-800">{{ \Carbon\Carbon::parse($meet->date)->format('F j, Y') }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Description</p>
                <p class="text-gray-700">{{ $meet->description ?? 'No description provided.' }}</p>
            </div>

            <a href="{{ route('admin-meets.edit', $meet->id) }}" class="inline-block mt-4 px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                Edit Meet
            </a>
        </div>

        <div class="my-8">
            <h1 class="text-3xl font-bold mb-6">
                Absensi untuk Peserta <span class="text-blue-500">{{ $workshop->title }}</span>
            </h1>
            <div class="flex w-auto">
                @if ($registrations->count() != 0)
                    <button id="mark-all-btn" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                        data-meet-id="{{ $meet->id }}"
                    >
                        Mark Present for All
                    </button>
                @endif
            </div>
        </div>

        @if ($registrations->count() != 0)
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <ul class="divide-y divide-gray-300">
                    <li>
                        @if (count($teachers) == 0)
                            <p>No teachers</p>
                        @endif
                        @foreach ($registrations as $registration)
                        @php
                            $presence = $registration->presences->where('meet_id', $meet->id)->first();
                            $isPresent = $presence?->isPresent ?? false;
                            $presenceId = $presence?->id ?? '';
                        @endphp 
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <a href="/teacherprofile/?teacherId={{ $registration->teacher->id }}">
                                        <p class="text-lg font-bold">{{ $registration->teacher->name }}</p>
                                    </a>
                                    <p class="text-sm text-gray-600">{{ $registration->teacher->school->name }}</p>
                                </div>
                                
                                <button
                                    id="validate-btn-{{ $registration->teacher->id }}" 
                                    class="validate-btn px-4 py-2 rounded text-white font-semibold transition-all duration-200 {{ $isPresent ? 'bg-green-500' : 'bg-blue-500' }} {{ $isPresent ? 'hover:bg-green-600' : 'hover:bg-blue-600' }}"
                                    data-presence-id="{{ $presenceId }}"
                                >
                                    <p>{{ $isPresent ? 'Present' : 'Not Present' }}</p>
                                </button>
                            </div>
                        @endforeach
                    </li>
                </ul>
            </div>
        @else
            <p class="text-gray-600 mb-4">Belum ada peserta yang mendaftar pada workshop ini.</p>
        @endif
    </div>

    <script>
        document.querySelectorAll('.validate-btn').forEach(button => {
            button.addEventListener('click', function () {
                const presenceId = this.dataset.presenceId;  // Get the presenceId from the data attribute
                const url = `/mark-present/${presenceId}`;  // Construct the correct URL
    
                // Send AJAX request to update presence
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button color and text based on the updated presence status
                        this.classList.remove('bg-blue-500', 'bg-green-500');
                        this.classList.remove('hover:bg-blue-600', 'hover:bg-green-600');
                        this.classList.add(data.isPresent ? 'bg-green-500' : 'bg-blue-500');
                        this.classList.add(data.isPresent ? 'hover:bg-green-600' : 'hover:bg-blue-600');
                
                        // Update the button text based on the presence status
                        this.querySelector('p').textContent = data.isPresent ? 'Present' : 'Not Present';
                    } else {
                        alert('Failed to mark presence.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            });
        });

        document.querySelector('#mark-all-btn').addEventListener('click', function () {
            const presenceBtns = document.querySelectorAll('.validate-btn');
            const meetId = this.dataset.meetId;
            const url = `/mark-all-present/${meetId}`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    presenceBtns.forEach(btn => {
                        btn.classList.remove('bg-blue-500', 'bg-green-500');
                        btn.classList.remove('hover:bg-blue-600', 'hover:bg-green-600');
                        btn.classList.add(data.isPresent ? 'bg-green-500' : 'bg-blue-500');
                        btn.classList.add(data.isPresent ? 'hover:bg-green-600' : 'hover:bg-blue-600');
                        btn.querySelector('p').textContent = data.isPresent ? 'Present' : 'Not Present';
                    });
                } else {
                    alert('Failed to mark all presences.');
                }
            })
        });
    </script>

</x-admin-layout>
