<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Instansi</h1>

        <a href="{{ route('admin-schools.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Buat Data Instansi
        </a>

        {{-- Teacher List --}}
        <div class="bg-white shadow rounded-lg">
            @forelse ($schools as $school)
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50">
                    <p class="text-lg font-bold">{{ $school->name }}</p>
                    <p class="text-sm text-gray-600">
                        Alamat: {{ $school->address ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Kota: {{ $school->city ?? 'N/A' }}
                    </p>
                </div>
            @empty
                <p class="p-4 text-gray-500">Belum ada instansi yang terdaftar.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $schools->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin-layout>