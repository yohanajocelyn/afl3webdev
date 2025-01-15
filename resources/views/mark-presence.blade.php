<x-layout>
    <div class="bg-gray-100 my-8">

        <h1 class="text-3xl font-bold mb-6">
            Absensi untuk Peserta <span class="text-blue-500">{{ $workshop->title }}</span>
        </h1>
                <div class="flex w-auto">
            <input type="text" placeholder="Search teachers..." class="border p-2 rounded-md w-full sm:w-64 focus:outline-blue-400" />
            <button class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Search
            </button>
            <button id="mark-all-btn" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                data-meet-id="{{ $meet->id }}"
            >
                Mark Present for All
            </button>
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <ul class="divide-y divide-gray-300">
            <li>
                @if (count($teachers) == 0)
                    <p>No teachers</p>
                @endif
                @foreach ($registrations as $registration)
                @php
                    $presence = $registration->presences->where('meet_id', $meet->id)->first();
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
                            class="validate-btn px-4 py-2 rounded text-white font-semibold transition-all duration-200 {{ $presence->isPresent ? 'bg-green-500' : 'bg-blue-500' }} {{ $presence->isPresent ? 'hover:bg-green-600' : 'hover:bg-blue-600' }}"
                            data-presence-id="{{ $presence->id }}"
                        >
                            <p>{{ $presence->isPresent ? 'Present' : 'Not Present' }}</p>
                        </button>
                    </div>
                @endforeach
            </li>
        </ul>
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

</x-layout>
