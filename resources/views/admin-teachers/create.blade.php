<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">
            {{ isset($teacher) ? 'Edit Teacher Account' : 'Create Teacher Account' }}
        </h1>

        <form action="{{ isset($teacher) ? route('admin-teachers.update', $teacher->id) : route('admin-teachers.store') }}"
            method="POST" class="space-y-6">
            @csrf
            @if(isset($teacher))
                @method('PUT')
            @endif

            {{-- Full Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $teacher->name ?? '') }}"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $teacher->email ?? '') }}"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- School --}}
            <div>
                <label for="school_id" class="block text-sm font-medium text-gray-700">School</label>
                <select name="school_id" id="school_id" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
                    <option value="">Select School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}"
                            {{ (old('school_id') ?? $teacher->school_id ?? '') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" required
                        class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
                    <option value="user" {{ (old('role', $teacher->role ?? '') == 'user') ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ (old('role', $teacher->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ (old('role', $teacher->role ?? '') == 'superadmin') ? 'selected' : '' }}>Superadmin</option>
                </select>
            </div>

            {{-- Password (only for create or optional edit) --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    {{ isset($teacher) ? 'New Password (leave blank to keep current)' : 'Password' }}
                </label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    {{ isset($teacher) ? 'Update Teacher' : 'Create Teacher' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>