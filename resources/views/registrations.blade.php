<x-layout>
    <div class="bg-gray-100 my-8">
        @if (request('workshopId'))
            <p>{{ $workshop['title'] }}</p>
            <p>{{ $workshop['startDate']->format('F j, Y') }}</p>
        @endif

        <h1 class="text-3xl font-bold mb-4">Registrations</h1>

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
                                        <span class="material-symbols-outlined">
                                            image
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layout>
