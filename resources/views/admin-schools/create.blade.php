<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">
            {{ isset($school) ? 'Edit Data Instansi' : 'Buat Data Instansi' }}
        </h1>

        <form action="{{ isset($school) ? route('admin-schools.update', $school->id) : route('admin-schools.store') }}"
            method="POST" class="space-y-6">
            @csrf
            @if(isset($school))
                @method('PUT')
            @endif

            {{-- Nama Instansi --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                <input type="text" name="name" id="name" value="{{ old('name', $school->name ?? '') }}"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Alamat --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="address" id="address" value="{{ old('address', $school->address ?? '') }}"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Kota --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="city" id="city" value="{{ old('city', $school->kota ?? '') }}"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    {{ isset($school) ? 'Update Data Instansi' : 'Buat Data Instansi' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
