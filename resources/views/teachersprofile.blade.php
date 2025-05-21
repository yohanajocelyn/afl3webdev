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
                            {{-- <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['gender'] }}</p>
                            </div> --}}
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
                            {{-- <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['subjectTaught'] }}</p>
                            </div> --}}
                        </div>

                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">NUPTK</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['nuptk'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Komunitas</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['community'] ?? '-'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Edit Profile Button --}}
                <div class="flex justify-end">
                    <button onclick="document.getElementById('editModal').classList.remove('hidden')"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                        Edit Profil
                    </button>
                </div>
            {{-- Edit Profile Modal --}}
            <div id="editModal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
                    {{-- Close Button --}}
                    <button onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-xl">&times;</button>

                    <h2 class="text-xl font-semibold mb-4">Edit Profil</h2>

                    <form action="{{ route('edit-profile')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" name="name" value="{{ $teacher['name'] }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                            </div>
                            {{-- <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select name="gender"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                                    <option value="Laki-laki" @if ($teacher['gender'] == 'Laki-laki') selected @endif>
                                        Laki-laki</option>
                                    <option value="Perempuan" @if ($teacher['gender'] == 'Perempuan') selected @endif>
                                        Perempuan</option>
                                </select>
                            </div> --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ $teacher['email'] }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <input type="text" name="phone_number" value="{{ $teacher['phone_number'] }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                            </div>
                            {{-- <div>
                                <label class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                <input type="text" name="subject" value="{{ $teacher['subjectTaught'] }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                            </div> --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NUPTK</label>
                                <input type="text" name="nuptk" value="{{ $teacher['nuptk'] }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Komunitas</label>
                                <input type="text" name="community" value="{{ $teacher['community'] }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>
