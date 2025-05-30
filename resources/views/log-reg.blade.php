<x-layout>
    <section class="bg-gray-100 h-min-screen flex items-center justify-center flex-col">
        <div class="w-full max-w-xl bg-white shadow-lg rounded-md p-8 my-10">

            <!-- Conditional Forms -->
            @if (request('form') === 'register')
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <h2 class="text-2xl font-semibold text-gray-700">Register</h2>

                    <!-- Name -->
                    <div class="flex flex-col">
                        <label for="name" class="text-sm font-medium text-gray-600">Nama</label>
                        <input id="name" name="name" type="text"
                            class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan nama anda"
                            required />
                        @error('name')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- School -->
                    <div class="flex flex-col">
                        <label for="school" class="text-sm font-medium text-gray-600">Instansi</label>
                        <div class="flex gap-2">
                            <select id="school" name="school"
                                class="border rounded-md p-2 w-full focus:outline-blue-400">
                                <option value="" disabled selected>Pilih Instansi</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->name }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="addSchoolButton"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Tambah
                            </button>
                        </div>
                        @error('school')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror

                        <!-- Hidden input for adding a new school -->
                        <div id="newSchoolInput" class="flex flex-col hidden">
                            <input type="text" id="newSchoolName" name="newSchoolName"
                                class="border rounded-md p-2 mt-2 focus:outline-blue-400"
                                placeholder="Masukkan nama instansi" />
                            <input type="text" id="newSchoolAddress" name="newSchoolAddress"
                                class="border rounded-md p-2 mt-2 focus:outline-blue-400"
                                placeholder="Masukkan alamat instansi" />
                            <input type="text" id="newSchoolCity" name="newSchoolCity"
                                class="border rounded-md p-2 mt-2 focus:outline-blue-400"
                                placeholder="Masukkan kota instansi" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input id="email" name="email" type="email"
                            class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan email anda"
                            required />
                        @error('email')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="flex flex-col">
                        <label for="phone" class="text-sm font-medium text-gray-600">Nomor Handphone</label>
                        <input id="phone" name="phone" type="text"
                            class="border rounded-md p-2 focus:outline-blue-400"
                            placeholder="Masukkan nomor handphone anda" required />
                        @error('phone')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col">
                        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                        <input id="password" name="password" type="password"
                            class="border rounded-md p-2 focus:outline-blue-400" placeholder="Buat password" required />
                        @error('password')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NUPTK -->
                    <div class="flex flex-col">
                        <label for="nuptk" class="text-sm font-medium text-gray-600">NUPTK</label>
                        <input id="nuptk" name="nuptk" type="text"
                            class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan kode NUPTK"
                            required />
                        @error('nuptk')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Community -->
                    <div class="flex flex-col">
                        <label for="community" class="text-sm font-medium text-gray-600">Komunitas</label>
                        <input id="community" name="community" type="text"
                            class="border rounded-md p-2 focus:outline-blue-400"
                            placeholder="Masukkan nama komunitas (bila ada)" />
                        @error('community')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mentor -->
                    <div class="flex flex-col">
                        <label for="mentor" class="text-sm font-medium text-gray-600">Mentor Anda</label>
                        <div class="flex gap-2">
                            <select id="mentor" name="mentor"
                                class="border rounded-md p-2 w-full focus:outline-blue-400">
                                <option value="" disabled selected required>Pilih Mentor</option>
                                @foreach ($mentors as $mentor)
                                    <option value="{{ $mentor->name }}">{{ $mentor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('mentor')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <input id="pageBefore" name="pageBefore" type="hidden" value="{{ url()->previous() }}">
                    <button type="submit"
                        class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Register</button>

                    <!-- Toggle to Login -->
                    <p class="text-sm text-center text-gray-600 mt-4">
                        Sudah memiliki akun?
                        <a href="?form=login" class="text-blue-500 hover:underline">Login</a>
                    </p>
                </form>

            @elseif(request('form') === 'login' || !request('form'))
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-700">Login</h2>

                    <!-- Email -->
                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input id="email" name="email" type="email"
                            class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan email anda"
                            required />
                        @error('email')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col">
                        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                        <input id="password" name="password" type="password"
                            class="border rounded-md p-2 focus:outline-blue-400" placeholder="Masukkan password anda"
                            required />
                        @error('password')
                            <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <input id="pageBefore" name="pageBefore" type="hidden" value="{{ url()->previous() }}">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Login</button>

                    <!-- Toggle to Register -->
                    <p class="text-sm text-center text-gray-600 mt-4">
                        Belum memiliki akun?
                        <a href="?form=register" class="text-blue-500 hover:underline">Registrasi</a>
                    </p>
                </form>
            @endif
        </div>
    </section>

    <script>
        document.getElementById('addSchoolButton')?.addEventListener('click', function () {
            const newSchoolInput = document.getElementById('newSchoolInput');
            const schoolSelect = document.getElementById('school');

            newSchoolInput.classList.toggle('hidden');
            schoolSelect.selectedIndex = 0;

            if (!newSchoolInput.classList.contains('hidden')) {
                document.getElementById('newSchoolName').focus();
            }
        });
    </script>
</x-layout>
