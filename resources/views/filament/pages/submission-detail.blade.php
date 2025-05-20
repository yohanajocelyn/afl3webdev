<x-filament-panels::page :class="static::class">
    <div class="bg-gray-900 rounded-xl border border-gray-800 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-800 bg-gray-950">
            <h3 class="text-lg font-medium text-gray-100">Submission Detail</h3>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Subject -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Subject</label>
                    <div class="text-gray-200">{{ $submission->subject }}</div>
                </div>

                <!-- Title -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Title</label>
                    <div class="text-gray-200">{{ $this->submission->title }}</div>
                </div>

                <!-- Education Level -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Education Level</label>
                    <div class="text-gray-200">{{ $this->submission->educationLevel }}</div>
                </div>

                <!-- Student Amount -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Student Amount</label>
                    <div class="text-gray-200">{{ $this->submission->studentAmount }}</div>
                </div>

                <!-- Duration -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Duration (minutes)</label>
                    <div class="text-gray-200">{{ $this->submission->duration }}</div>
                </div>

                <!-- Onsite -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Onsite?</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                              {{ $this->submission->isOnsite ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                        {{ $this->submission->isOnsite ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>

            <!-- Note -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-400">Note</label>
                <div class="text-gray-200">{{ $this->submission->note ?? '—' }}</div>
            </div>

            <!-- Assignment Link -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-400">Assignment</label>
                <a href="{{ route('admin-assignments.show', $this->submission->assignment->id) }}"
                   class="text-primary-400 hover:text-primary-300 hover:underline"
                   target="_blank">
                    View Assignment #{{ $this->submission->assignment->id }}
                </a>
            </div>

            <!-- Submitted URL -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-400">Submitted URL</label>
                <a href="{{ $this->submission->url }}"
                   class="text-primary-400 hover:text-primary-300 hover:underline break-all"
                   target="_blank">
                    {{ $this->submission->url }}
                </a>
            </div>

            <!-- Approval Button -->
            <div class="flex justify-end pt-4">
                <x-filament::button
                    wire:click="approve"
                    color="{{ $this->submission->isApproved ? 'danger' : 'primary' }}"
                >
                    {{ $this->submission->isApproved ? 'Revoke Approval' : 'Approve Submission' }}
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-panels::page>