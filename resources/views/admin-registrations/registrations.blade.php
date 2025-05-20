<x-admin-layout>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Registrations</h1>

    {{-- Filter Dropdown --}}
    <form method="GET" action="{{ route('admin-registrations.registrations') }}" class="mb-6">
        <label for="workshop_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Workshop:</label>
        <select name="workshop_id" id="workshop_id"
                onchange="this.form.submit()"
                class="block w-full md:w-1/3 border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Workshops</option>
            @if (count($workshops) > 0)
                @foreach ($workshops as $workshop)
                    <option value="{{ $workshop->id }}" {{ request('workshop_id') == $workshop->id ? 'selected' : '' }}>
                        {{ $workshop->title }}
                    </option>
                @endforeach
            @endif
        </select>
    </form>

    {{-- Registration List --}}
    <div class="bg-white shadow rounded-lg">
        @forelse ($registrations as $registration)
            <div class="p-4 hover:bg-blue-50 flex flex-col md:flex-row justify-between items-center border-b border-gray-100">
                <div>
                    <p class="text-lg font-bold">{{ $registration->teacher->name }}</p>
                    <p class="text-sm text-gray-600">
                        School: {{ $registration->teacher->school->name ?? 'N/A' }}
                    </p>
                </div>

                <div class="flex flex-row">
                    <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end space-y-2">
                        <p class="text-sm text-gray-600">
                            Registered on: {{ $registration->regDate->format('F j, Y') }}
                        </p>

                        <div class="flex space-x-4">
                            @if ($registration->workshop)
                                <a href="{{ route('workshop-detail', $registration->workshop) }}"
                                    class="text-blue-500 hover:underline text-sm">
                                    Show Workshop
                                </a>
                            @endif
                            <a href="/teacherprofile?teacherId={{ $registration->teacher->id }}"
                                class="text-blue-500 hover:underline text-sm">
                                Show Profile
                            </a>
                        </div>
                    </div>

                    @if ($registration->workshop->price != 0)
                        <a href="{{ asset($registration->paymentProof) }}" target="_blank" class="flex flex-row items-center space-x-2 ml-6">
                            <span class="material-symbols-outlined text-blue-500">
                                image
                            </span>
                        </a>

                        <button 
                            id="approve-btn-{{ $registration->teacher->id }}" 
                            class="approve-btn flex flex-row items-center space-x-2 ml-4 {{ $registration->isApproved ? 'text-green-500' : 'text-red-500' }}"
                            data-registration-id="{{ $registration->id }}">
                            <span class="material-symbols-outlined">
                                {{ $registration->isApproved ? 'check' : 'cancel' }}
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <p class="p-4 text-gray-500">No registrations found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $registrations->appends(request()->query())->links() }}
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

</x-admin-layout>
