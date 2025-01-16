<x-layout>
    <div class="bg-gray-100 my-8">
        @if (request('workshopId'))
            <h1 class="text-3xl font-bold mb-2">{{ $workshop['title'] }}</h1>
            <p>{{ $workshop['startDate']->format('F j, Y') }}</p>
        @endif

        <h1 class="text-3xl font-bold my-4">Registrations</h1>

        <div class="p-6 bg-white rounded-lg shadow-lg">
            @if (count($registrations) == 0)
                <p>No registrations found.</p>
            @else
                <ul class="divide-y divide-gray-300">
                    @foreach ($registrations as $registration)
                        <div class="p-4 hover:bg-blue-50 flex flex-col md:flex-row justify-between items-center">
                            <div>
                                <!-- Teacher Name -->
                                <p class="text-lg font-bold">{{ $registration['teacher']['name'] }}</p>

                                <!-- School Name -->
                                <p class="text-sm text-gray-600">
                                    School: {{ $registration['teacher']['school']['name'] ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="flex flex-row">
                                <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end space-y-2">
                                    <!-- Registration Date -->
                                    <p class="text-sm text-gray-600">
                                        Registered on: {{ $registration['regDate']->format('F j, Y') }}
                                    </p>

                                    <!-- Links -->
                                    <div class="flex space-x-4">
                                        @if ($registration['workshop'])
                                            <a href="{{ route('workshop-detail', $registration['workshop']) }}"
                                                class="text-blue-500 hover:underline text-sm">
                                                Show Workshop
                                            </a>
                                        @endif
                                        <a href="/teacherprofile?teacherId={{ $registration['teacher']['id'] }}"
                                            class="text-blue-500 hover:underline text-sm">
                                            Show Profile
                                        </a>
                                    </div>
                                </div>
                                @if ($registration['workshop']['price'] != 0)
                                    <a href="{{ asset($registration['paymentProof']) }}" target="_blank" class="flex flex-row items-center space-x-2 ml-6">
                                        <span class="material-symbols-outlined text-blue-500">
                                            image
                                        </span>
                                    </a>
                                    <button 
                                    id="approve-btn-{{ $registration->teacher->id }}" 
                                    class="approve-btn flex flex-row items-center space-x-2 ml-4 {{ $registration->isApproved ? 'text-green-500' : 'text-red-500' }}"
                                    data-registration-id ={{ $registration->id }}
                                    >
                                        <span class="material-symbols-outlined">
                                            {{ $registration->isApproved ? 'check' : 'cancel' }}
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function () {
                const registrationId = this.dataset.registrationId;
                const url = `/setApprove/${registrationId}`;
    
                // Send AJAX request to update registration
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
                        // Update button color and text based on the updated registration status
                        this.classList.remove('text-green-500', 'text-red-500');
                        this.classList.add(data.isApproved ? 'text-green-500' : 'text-red-500');
                
                        // Update the button text based on the registration status
                        this.querySelector('.material-symbols-outlined').textContent = data.isApproved ? 'check' : 'cancel';
                    } else {
                        alert('Failed to approve registration.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            });
        });
    </script>

</x-layout>
