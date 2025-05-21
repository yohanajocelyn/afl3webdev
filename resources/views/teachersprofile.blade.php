<x-layout>
    <section class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
        {{-- box --}}
        <div class="bg-white shadow-lg rounded-lg p-8 w-3/4 space-y-10">
            {{-- profile --}}
            <div class="flex flex-row items-center space-x-10">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-48 h-48 bg-gray-300 rounded-full overflow-hidden">
                        <img src="{{ asset($teacher['pfpURL']) }}" alt="Profile Picture"
                            class="object-cover w-full h-full">
                    </div>
                </div>

                {{-- profile details --}}
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-6">Profil Pengguna</h1>
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['name'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['gender'] }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['email'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['phone_number'] }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Instansi</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['school']['name'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['subjectTaught'] }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">NUPTK</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['nuptk'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Komunitas</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['community'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
</x-layout>