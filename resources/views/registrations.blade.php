<x-layout>
    <div class="bg-gray-100 container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-4">{{ $title ?? '' }}</h1>
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <!-- Search bar on the right for large screens, on top for small screens -->
            <div class="flex w-auto">
                <input type="text" placeholder="Search {{ $title ?? '' }}..." class="border p-2 rounded-md w-full sm:w-64 focus:outline-blue-400" />
                <button class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Search
                </button>
            </div>
        </div>

        <div class="rounded-lg">
            <ul class="space-y-4">
                <li>
                    @foreach ($workshop->registrations as $registration)
                        <div class="p-4 mb-4 flex flex-col justify-between bg-white rounded-lg">
                            <p class="text-md font-bold">{{ $registration->teacher['name'] }}</p>
                            <p class="text-md font-bold">{{ $registration->teacher->school['name'] }}</p>
                        </div>
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
</x-layout>
