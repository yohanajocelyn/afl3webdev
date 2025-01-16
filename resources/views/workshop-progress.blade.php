<x-layout>
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">{{ $workshop->name }} - Progress Table</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-300 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Daftar Peserta
                        </th>
                        @foreach($workshop->assignments as $assignment)
                            <th class="px-6 py-3 border-b border-gray-300 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ $assignment->title }}
                            </th>
                        @endforeach
                        <th class="px-6 py-3 border-b border-gray-300 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Approve All
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workshop->registrations as $registration)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                <a href="/teacherprofile?teacherId={{ $registration->teacher->id }}">
                                    {{ $registration->teacher->name }}
                                </a>
                            </td>
                            @foreach($workshop->assignments as $assignment)
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 items-center">
                                    <div class="flex flex-row items-center space-x-2">
                                        @php
                                            $submission = $registration->submissions->first(function($submission) use ($assignment) {
                                                return $submission->assignment_id === $assignment->id;
                                            });
                                        @endphp
                                        
                                        @if($submission)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Submitted
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Empty
                                            </span>
                                        @endif
                                        <button
                                            id="approve-btn-{{ $submission ? $submission->id : 0 }}"
                                            class="approve-btn flex flex-row items-center space-x-2 ml-4 {{ !$submission || ($submission && !$submission->isApproved) ? 'text-red-500' : 'text-green-500' }}"
                                            data-submission-id="{{ $submission ? $submission->id : 0 }}"
                                        >
                                            <span class="material-symbols-outlined text-sm">
                                                {{ !$submission || ($submission && !$submission->isApproved) ? 'cancel' : 'check' }}
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                <button 
                                    onclick="approveAll({{ $registration->id }})"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm"
                                >
                                    Approve All
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function () {
                const submissionId = this.dataset.submissionId;
                if(submissionId != 0){
                    const url = `/approveSubmission/${submissionId}`;
        
                    // Send AJAX request to update submission
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.classList.remove('text-red-500', 'text-green-500');
                            this.classList.add(data.isApproved ? 'text-green-500' : 'text-red-500');
                    
                            this.querySelector('.material-symbols-outlined').textContent = data.isApproved ? 'check' : 'cancel';
                        } else {
                            alert('Failed to approve submission.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                }
            });
        });
    </script>
</x-layout>