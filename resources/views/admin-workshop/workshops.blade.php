<x-admin-layout>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">All Workshops</h1>
        <a href="{{ route('admin-workshops-create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
            + Add New Workshop
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($workshops->isEmpty())
        <div class="p-6 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded text-center">
            No workshops available yet.
        </div>
    @else
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($workshops as $workshop)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    @if($workshop->imageURL)
                        <img src="{{ $workshop->imageURL }}" alt="{{ $workshop->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-5">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $workshop->title }}</h2>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($workshop->description, 100) }}</p>
                        <div class="text-sm text-gray-500 mb-2">
                            <span class="block"><strong>Meets:</strong> {{ $workshop->meets_count }}</span>
                            <span class="block"><strong>Assignments:</strong> {{ $workshop->assignments_count }}</span>
                        </div>
                        <a href="{{ route('admin-workshops.show', $workshop->id) }}" class="inline-block mt-3 text-blue-600 hover:text-blue-800 font-medium text-sm">
                            → View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-admin-layout>