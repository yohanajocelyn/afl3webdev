<x-filament-panels::page>
    <div class="space-y-6 filament-tables-container">
        <h2 class="text-xl font-bold tracking-tight filament-header-heading">
            {{ $workshop->title }} - {{ $assignment->title }} Submissions
        </h2>

        {{ $this->table }}

        {{-- <div class="bg-white rounded-xl border border-gray-300 shadow-sm overflow-hidden">
            <div class="overflow-x-auto relative">
                <table class="w-full text-start divide-y table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600">
                                Participant
                            </th>
                            <th class="px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600">
                                Submission Status
                            </th>
                            <th class="px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600">
                                Approve
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($workshop->registrations as $registration)
                            @php
                                $submission = $registration->submissions->firstWhere('assignment_id', $assignment->id);
                            @endphp
                            <tr class="filament-tables-row transition">
                                <td class="px-4 py-3 align-middle">
                                    <a href="/teacherprofile?teacherId={{ $registration->teacher->id }}" class="text-primary-600 hover:underline filament-link">
                                        {{ $registration->teacher->name }}
                                    </a>
                                </td>
                                
                                <td class="px-4 py-3 align-middle">
                                    @if($submission)
                                        <div class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl whitespace-nowrap bg-success-500/10 text-success-700 filament-badge">
                                            Submitted
                                        </div>
                                    @else
                                        <div class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl whitespace-nowrap bg-danger-500/10 text-danger-700 filament-badge">
                                            Empty
                                        </div>
                                    @endif
                                </td>
                                
                                <td class="px-4 py-3 align-middle">
                                    @if($submission)
                                        <button
                                            id="approve-btn-{{ $submission->id }}"
                                            class="approve-btn flex items-center justify-center rounded-full w-10 h-10 text-primary-500 outline-none filament-icon-button {{ $submission->isApproved ? 'text-success-500' : 'text-danger-500' }}"
                                            data-submission-id="{{ $submission->id }}"
                                        >
                                            @if($submission->isApproved)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm italic">No submission</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.approve-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const submissionId = this.dataset.submissionId;
                    const url = `/approveSubmission/${submissionId}`;
                    const isCurrentlyApproved = this.classList.contains('text-success-500');

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
                            // Update button appearance
                            this.classList.remove('text-success-500', 'text-danger-500');
                            this.classList.add(data.isApproved ? 'text-success-500' : 'text-danger-500');
                            
                            // Change the icon
                            if (data.isApproved) {
                                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                            } else {
                                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                            }

                            // Show notification using whatever notification system is available
                            const message = data.isApproved ? 'Submission approved' : 'Submission unapproved';
                            
                            if (window.$wireui) {
                                window.$wireui.notify({
                                    title: 'Success',
                                    description: message,
                                    icon: 'success'
                                });
                            } else if (window.Livewire) {
                                window.Livewire.dispatch('notify', {
                                    style: 'success',
                                    message: message,
                                    timeout: 3000
                                });
                            } else {
                                // Filament v3 notification
                                const event = new CustomEvent('filament-notification', {
                                    bubbles: true,
                                    detail: {
                                        type: 'success',
                                        message: message,
                                        duration: 3000
                                    }
                                });
                                window.dispatchEvent(event);
                            }
                        } else {
                            // Show error notification
                            if (window.$wireui) {
                                window.$wireui.notify({
                                    title: 'Error',
                                    description: 'Failed to approve submission.',
                                    icon: 'error'
                                });
                            } else if (window.Livewire) {
                                window.Livewire.dispatch('notify', {
                                    style: 'danger',
                                    message: 'Failed to approve submission.',
                                    timeout: 3000
                                });
                            } else {
                                // Filament v3 notification
                                const event = new CustomEvent('filament-notification', {
                                    bubbles: true,
                                    detail: {
                                        type: 'danger',
                                        message: 'Failed to approve submission.',
                                        duration: 3000
                                    }
                                });
                                window.dispatchEvent(event);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Show generic error notification
                        if (window.$wireui) {
                            window.$wireui.notify({
                                title: 'Error',
                                description: 'An error occurred. Please try again.',
                                icon: 'error'
                            });
                        } else if (window.Livewire) {
                            window.Livewire.dispatch('notify', {
                                style: 'danger',
                                message: 'An error occurred. Please try again.',
                                timeout: 3000
                            });
                        } else {
                            // Filament v3 notification
                            const event = new CustomEvent('filament-notification', {
                                bubbles: true,
                                detail: {
                                    type: 'danger',
                                    message: 'An error occurred. Please try again.',
                                    duration: 3000
                                }
                            });
                            window.dispatchEvent(event);
                        }
                    });
                });
            });
        });
    </script>
</x-filament-panels::page>