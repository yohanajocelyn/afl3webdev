<x-layout>
    <div class="mb-6 mt-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $assignment->title }}</h1>
        <p class="text-gray-600 mt-2">{{ $assignment->date }}</p>
    </div>
    <div class="border-t border-gray-300 mt-6 pt-4">

        {{-- show users submission --}}
        @if ($userSubmission)
            <div class="mb-6 p-4 border rounded bg-white shadow">
                <h3 class="text-xl font-semibold mb-2">Your Submission</h3>

                <p><strong>Link:</strong>
                    <a href="{{ $userSubmission->url }}" target="_blank" class="text-blue-600 underline">
                        {{ $userSubmission->url }}
                    </a>
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    <strong>Submitted File:</strong>
                    <a href="{{ asset($userSubmission->path) }}" target="_blank" class="text-blue-600 underline">
                        View Submission PDF
                    </a>
                </p>
                <p><strong>Note:</strong> {{ $userSubmission->note ?? 'No notes' }}</p>

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
                @if ($userSubmission->status === 'rejected')
                    <p class="text-sm text-red-600 mt-1">
                        <strong>Revision Note:</strong>
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
                            Remove Submission
                        </button>
                    </form>
                    <button id="editSubmissionButton" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                        Edit Submission
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
                                <input id="submissionLinkEdit" name="submissionLink" type="url"
                                    class="border rounded-lg px-3 py-2 w-full" required
                                    value="{{ old('submissionLink', $userSubmission->url ?? '') }}">
                                <label for="submissionFileEdit">File PDF:</label>
                                <input id="submissionFileEdit" name="submissionFile" type="file"
                                    class="border rounded-lg px-3 py-2 w-full">

                                @if ($userSubmission->path)
                                    <p class="text-sm text-gray-500 mt-1">Current File:
                                        <a href="{{ asset($userSubmission->path) }}" target="_blank"
                                            class="text-blue-600 underline">
                                            View Submission PDF
                                        </a>
                                    </p>
                                @endif
                            </div>
                            <div class="mb-4">
                                <label for="submissionNoteEdit" class="block text-gray-700 font-bold mb-2">Note:</label>
                                <textarea id="submissionNoteEdit" name="submissionNote" class="border rounded-lg px-3 py-2 w-full">{{ $userSubmission->note }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" id="closeEditSubmissionModalButton"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                    Save Changes
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
                    Submit Work
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
                            <label for="submissionText" class="block text-gray-700 font-bold mb-2">Link Google
                                Drive:</label>
                            <input id="submissionLink" name="submissionLink" class="border rounded-lg px-3 py-2 w-full"
                                required type="text">
                            <label for="submissionFile" class="block text-gray-700 font-bold mb-2">
                                PDF File (max ...)
                            </label>
                            <input id="submissionFile" name="submissionFile" required type="file">
                        </div>
                        <div class="mb-4">
                            <label for="submissionNote" class="block text-gray-700 font-bold mb-2">Note:</label>
                            <textarea id="submissionNote" name="submissionNote" class="border rounded-lg px-3 py-2 w-full">-</textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="closeSubmitModalButton"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">
                                Cancel
                            </button>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                                Submit
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
