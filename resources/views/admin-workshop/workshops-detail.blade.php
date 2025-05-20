<x-admin-layout>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        @if($workshop->imageURL)
            <img src="{{ $workshop->imageURL }}" alt="{{ $workshop->title }}" class="w-full h-64 object-cover">
        @endif

        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">{{ $workshop->title }}</h1>
                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-gray-700">Status:</label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                            id="toggleStatus"
                            data-id="{{ $workshop->id }}"
                            class="sr-only peer"
                            {{ $workshop->isOpen ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-300 peer-checked:bg-green-500 rounded-full peer peer-focus:ring-2 ring-offset-2 ring-green-400 transition duration-300"></div>
                        <span id="statusText" class="ml-2 text-sm">
                            {{ $workshop->isOpen ? 'Open' : 'Closed' }}
                        </span>
                    </label>
                </div>
            </div>

            <p class="text-gray-600 mb-4">{{ $workshop->description }}</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Start Date</p>
                    <p class="font-medium text-gray-800">{{ $workshop->startDate->format('F j, Y') }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">End Date</p>
                    <p class="font-medium text-gray-800">{{ $workshop->endDate->format('F j, Y') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-6 text-sm text-gray-700 mb-6">
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Price:</span> Rp{{ number_format($workshop->price, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Meets:</span> {{ $workshop->meets->count() }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Assignments:</span> {{ $workshop->assignments->count() }}
                </div>
            </div>
        </div>

        <div class="pl-4 pb-4">
            <a href="{{ route('admin-workshops.edit', $workshop->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                Edit Workshop
            </a>
        </div>

        <!-- Meet Cards Section -->
        <div class="p-6 pt-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Meets</h2>
                <a href="{{ route('admin-meets.create', ['workshop_id' => $workshop->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Meet
                </a>
            </div>
            
            @if($workshop->meets->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($workshop->meets as $meet)
                        <a href="{{ route('admin-meets.show', $meet->id) }}" class="block bg-white border border-gray-200 shadow rounded-lg p-4 hover:bg-gray-50 transition">
                            <h3 class="font-bold text-gray-900">{{ $meet->title }}</h3>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($meet->date)->format('F j, Y') }}</p>
                            <p class="text-gray-700 mt-1">{{ $meet->description }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-600 mb-4">No meets have been scheduled for this workshop yet.</p>
                </div>
            @endif
        </div>

        <!-- Assignment Cards Section -->
        <div class="p-6 pt-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Assignments</h2>
                <a href="{{ route('admin-assignments.create', ['workshop_id' => $workshop->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Assignment
                </a>
            </div>
            
            @if($workshop->assignments->count() > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($workshop->assignments as $assignment)
                        <a href="{{ route('admin-assignments.edit', $assignment->id) }}" class="block bg-white border border-gray-200 shadow rounded-lg p-4 hover:bg-gray-50 transition">
                            <h3 class="font-bold text-gray-900">{{ $assignment->title }}</h3>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($assignment->date)->format('F j, Y') }}</p>
                            <p class="text-gray-700 mt-1">{{ $assignment->description }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-600 mb-4">No assignments have been created for this workshop yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('toggleStatus');
        const statusText = document.getElementById('statusText');

        toggle.addEventListener('change', function () {
            const workshopId = this.getAttribute('data-id');

            fetch(`/admin-workshops/${workshopId}/toggle-status`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusText.textContent = data.isOpen ? 'Open' : 'Closed';
                } else {
                    alert('Failed to update status.');
                    toggle.checked = !toggle.checked; // revert toggle
                }
            })
            .catch(() => {
                alert('Error communicating with server.');
                toggle.checked = !toggle.checked;
            });
        });
    });
</script>

</x-admin-layout>