<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Teachers</h1>

        <a href="{{ route('admin-teachers.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Create Teacher Account
        </a>

        {{-- Filter by School --}}
        <form method="GET" action="{{ route('admin-teachers.teachers') }}" class="mb-6">
            <label for="school_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by School:</label>
            <select name="school_id" id="school_id"
                    onchange="this.form.submit()"
                    class="block w-full md:w-1/3 border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Schools</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Teacher List --}}
        <div class="bg-white shadow rounded-lg">
            @forelse ($teachers as $teacher)
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50">
                    <p class="text-lg font-bold">{{ $teacher->name }}</p>
                    <p class="text-sm text-gray-600">
                        School: {{ $teacher->school->name ?? 'N/A' }}
                    </p>
                </div>
            @empty
                <p class="p-4 text-gray-500">No teachers found.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $teachers->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin-layout>