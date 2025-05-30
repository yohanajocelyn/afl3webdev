<x-layout>
    <div class="mb-6 mt-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $assignment->title }}</h1>
        <p class="text-gray-600 mt-4">Pelatihan : {{ $assignment->workshop['title'] }}</p>
        <p class="text-gray-600 mt-2">Waktu Tenggat: {{ $assignment->due_dateTime }}</p>
        <p class="text-gray-600 mt-4">{{ $assignment->description }}</p>
        @if ($assignment->url)
            <p class="text-gray-600 mt-2">Link Template : <a class="text-blue-500 underline"
                    href="{{ $assignment->url }}">{{ $assignment->url }}</a></p>
        @endif
    </div>
    <div class="border-t border-gray-300 mt-6 pt-4">

        {{-- show users submission --}}
        @if ($userSubmission)
            <div class="mb-6 p-4 border rounded bg-white shadow">
                <h3 class="text-xl font-semibold mb-2">Pengumpulan Anda</h3>

                <p><strong>Link:</strong>
                    <a href="{{ $userSubmission->url }}" target="_blank" class="text-blue-600 underline">
                        {{ $userSubmission->url }}
                    </a>
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    <strong>File Terkumpul:</strong>
                    <a href="{{ asset($userSubmission->path) }}" target="_blank" class="text-blue-600 underline">
                        Lihat PDF Terkumpul
                    </a>
                </p>
                <p><strong>Catatan:</strong> {{ $userSubmission->note ?? 'Tidak ada catatan' }}</p>

                <p><strong>Status:</strong>
                    @php
                        $status = $userSubmission->status->value;
                    @endphp
                    <span
                        class="@switch($status)
                        @case('approved')
                        text-green-500
                        @break
                        @case('pending')
                        text-yellow-500
                        @break
                        @case('rejected')
                        text-red-500
                        @break
                    @endswitch">
                        {{ ucfirst($status) }}
                    </span>
                </p>
                {{-- file and revision note shown when rejected --}}
                @if ($userSubmission->status->value === 'rejected')
                    <p class="text-sm text-red-600 mt-1">
                        <strong>Catatan Revisi:</strong>
                        {{ $userSubmission->revisionNote ?? 'No revision notes provided.' }}
                    </p>
                @endif
            </div>

            {{-- edit and remove button --}}
            @if (!$userSubmission->isApproved)
                <div class="flex justify-end gap-4">
                    <form action="{{ route('delete-submission', ['id' => $userSubmission->id]) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete your submission?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">
                            Hapus Pengumpulan
                        </button>
                    </form>
                    <button id="editSubmissionButton" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                        Edit Pengumpulan
                    </button>
                </div>
            @endif


            {{-- edit submission modal --}}
            @if (!$userSubmission->isApproved)
                <div id="editSubmissionModal"
                    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                        <h2 class="text-2xl font-bold mb-4">Edit Pengumpulan</h2>

                        <form action="{{ route('submit-assignment', ['id' => $assignment->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="submissionLinkEdit" class="block text-gray-700 font-bold mb-2">Link
                                    Google
                                    Drive:</label>
                                <input id="submissionLinkEdit" name="submissionLink" type="url/string"
                                    class="border rounded-lg px-3 py-2 w-full"
                                    value="{{ old('submissionLink', $userSubmission->url ?? '') }}" required>
                                <label for="submissionFileEdit">File PDF:</label>
                                <input id="submissionFileEdit" name="submissionFile" type="file"
                                    accept="pdf" class="border rounded-lg px-3 py-2 w-full">

                                {{-- Display file size error for edit form --}}
                                @error('submissionFile')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                @if ($userSubmission->path)
                                    <p class="text-sm text-gray-500 mt-1">File Saat Ini:
                                        <a href="{{ asset($userSubmission->path) }}" target="_blank"
                                            class="text-blue-600 underline">
                                            Lihat PDF Terkumpul
                                        </a>
                                    </p>
                                @endif
                            </div>
                            <div class="mb-4">
                                <label for="submissionNoteEdit"
                                    class="block text-gray-700 font-bold mb-2">Catatan:</label>
                                <textarea id="submissionNoteEdit" name="submissionNote" class="border rounded-lg px-3 py-2 w-full">{{ old('submissionNote', $userSubmission->note ?? '') }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" id="closeEditSubmissionModalButton"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">
                                    Batal
                                </button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @else
            {{-- No submission yet: Show Submit Work button --}}
            <div class="flex justify-end">
                <button id="submitWorkButton" class="bg-green-500 text-white px-4 py-2 rounded-md">
                    Kumpulkan Tugas
                </button>
            </div>

            {{-- Submit Popup --}}
            <div id="submitWorkModal"
                class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                    <h2 class="text-2xl font-bold mb-4">Kumpulkan Hasil Anda</h2>

                    <form action="{{ route('submit-assignment', ['id' => $assignment['id']]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="submissionLink" class="block text-gray-700 font-bold mb-2">Link Google
                                Drive:</label>
                            <input id="submissionLink" name="submissionLink" class="border rounded-lg px-3 py-2 w-full"
                                type="url/string" value="{{ old('submissionLink') }}" required> {{-- Added type="url" and old() --}}
                            <label for="submissionFile" class="block text-gray-700 font-bold mb-2 mt-2">
                                {{-- Added mt-2 for spacing --}}
                                PDF File (max 1MB)
                            </label>
                            <input id="submissionFile" name="submissionFile" type="file" accept="application/pdf" required>

                            {{-- Display file size error for new submission form --}}
                            @error('submissionFile')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="submissionNote" class="block text-gray-700 font-bold mb-2">Catatan:</label>
                            <textarea id="submissionNote" name="submissionNote" class="border rounded-lg px-3 py-2 w-full">{{ old('submissionNote', '-') }}</textarea> {{-- Added old() and default '-' --}}
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="closeSubmitModalButton"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">
                                Batal
                            </button>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                                Kumpulkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Edit Modal Logic
        document.getElementById('editAssignmentButton')?.addEventListener('click', function() {
            document.getElementById('editAssignmentModal').classList.remove('hidden');
        });

        document.getElementById('closeEditModalButton')?.addEventListener('click', function() {
            document.getElementById('editAssignmentModal').classList.add('hidden');
        });

        // Submit Modal Logic
        document.getElementById('submitWorkButton')?.addEventListener('click', function() {
            document.getElementById('submitWorkModal').classList.remove('hidden');
        });

        document.getElementById('closeSubmitModalButton')?.addEventListener('click', function() {
            document.getElementById('submitWorkModal').classList.add('hidden');
        });

        // Edit Submission Modal Logic
        document.getElementById('editSubmissionButton')?.addEventListener('click', function() {
            document.getElementById('editSubmissionModal').classList.remove('hidden');
        });

        document.getElementById('closeEditSubmissionModalButton')?.addEventListener('click', function() {
            document.getElementById('editSubmissionModal').classList.add('hidden');
        });
    </script>
</x-layout>
