<x-layout>
    <section class="bg-gray-100 h-min-screen flex items-center justify-center flex-col">
        {{-- <!-- Toggle Links -->
            <div class="flex justify-between mb-6">
                <a href="?form=register" 
                   class="w-1/2 text-center py-2 text-white font-semibold rounded-l-md 
                          {{ request('form') === 'register'  ? 'bg-green-500' : 'bg-gray-200 text-gray-600' }}">
                    Register
                </a>
                <a href="?form=login" 
                   class="w-1/2 text-center py-2 text-white font-semibold rounded-r-md 
                          {{ request('form') === 'login'|| !request('form') ? 'bg-blue-500' : 'bg-gray-200 text-gray-600' }}">
                    Login
                </a>
            </div> --}}
        <div class="w-full max-w-xl bg-white shadow-lg rounded-md p-8 my-10">
            
            <!-- Conditional Forms -->
            @if(request('form') === 'register')
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <h2 class="text-2xl font-semibold text-gray-700">Register</h2>
                    
                    <!-- Profile Picture -->
                    <div class="flex flex-col">
                        <label for="profile_picture" class="text-sm font-medium text-gray-600">Foto Profil (Opsional)</label>
                        <input id="profile_picture" name="profile_picture" type="file" class="border rounded-md p-2 focus:outline-blue-400" accept="image/*" />
                    </div>

                    <!-- Name -->
                    <div class="flex flex-col">
                        <label for="name" class="text-sm font-medium text-gray-600">Nama</label>
                        <input id="name" name="name" type="text" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan nama anda" required />
                    </div>

                    <!-- School -->
                    <div class="flex flex-col">
                        <label for="school" class="text-sm font-medium text-gray-600">Instansi</label>
                        <div class="flex gap-2">
                            <select id="school" name="school" class="border rounded-md p-2 w-full focus:outline-blue-400">
                                <option value="" disabled selected>Pilih Instansi</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->name }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="addSchoolButton" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Tambah
                            </button>
                        </div>
                        <!-- Hidden input for adding a new school -->
                        <div id="newSchoolInput" class="flex flex-col hidden">
                            <input type="text" id="newSchoolName" name="newSchoolName" class="border rounded-md p-2 mt-2 focus:outline-blue-400" placeholder="Masukkan nama instansi" />
                            <input type="text" id="newSchoolAddress" name="newSchoolAddress" class="border rounded-md p-2 mt-2 focus:outline-blue-400" placeholder="Masukkan alamat instansi" />
                            <input type="text" id="newSchoolCity" name="newSchoolCity" class="border rounded-md p-2 mt-2 focus:outline-blue-400" placeholder="Masukkan kota instansi" />
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="male" required />
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="female" required />
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input id="email" name="email" type="email" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan email anda" required />
                        <!-- Display email error message -->
                        @error('email')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="flex flex-col">
                        <label for="phone" class="text-sm font-medium text-gray-600">Nomor Handphone</label>
                        <input id="phone" name="phone" type="text" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan nomor handphone anda" required />
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col">
                        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                        <input id="password" name="password" type="password" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Buat password" required />
                    </div>

                    <!-- NUPTK -->
                    <div class="flex flex-col">
                        <label for="nuptk" class="text-sm font-medium text-gray-600">NUPTK</label>
                        <input id="nuptk" name="nuptk" type="text" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan kode NUPTK" required />
                    </div>

                    <!-- Community -->
                    <div class="flex flex-col">
                        <label for="community" class="text-sm font-medium text-gray-600">Komunitas</label>
                        <input id="community" name="community" type="text" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan nama komunitas (bila ada)" />
                    </div>

                    <!-- Subject Taught -->
                    <div class="flex flex-col">
                        <label for="subject" class="text-sm font-medium text-gray-600">Materi Yang Diajarkan</label>
                        <input id="subject" name="subject" type="text" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan materi yang diajarkan" />
                    </div>
                    <input id="pageBefore" name="pageBefore" type="hidden" value="{{ url()->previous() }}">
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Register</button>
                </form>
            @elseif(request('form') === 'login' || !request('form'))
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-700">Login</h2>
                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input id="email" name="email" type="email" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan email anda" required />
                    </div>
                    <div class="flex flex-col">
                        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                        <input id="password" name="password" type="password" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan password anda" required />
                    </div>

                    <input id="pageBefore" name="pageBefore" type="hidden" value="{{ url()->previous() }}">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Login</button>
                </form>
            @endif
        </div>
    </section>

    <script>
        // JavaScript to handle toggling of the new school input
        document.getElementById('addSchoolButton').addEventListener('click', function () {
            const newSchoolInput = document.getElementById('newSchoolInput');
            newSchoolInput.classList.toggle('hidden');
            newSchoolInput.focus();
        });
    </script>
</x-layout>
