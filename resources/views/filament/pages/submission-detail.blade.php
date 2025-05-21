<x-filament-panels::page :class="static::class">
    <div class="bg-gray-900 rounded-xl border border-gray-800 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-800 bg-gray-950">
            <h3 class="text-lg font-medium text-gray-100">Submission Detail</h3>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Title -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Title</label>
                    <div class="text-gray-200">{{ $submission->title }}</div>
                </div>

                <!-- Teacher & Workshop -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-400">Teacher - Workshop</label>
                    <div class="text-gray-200">{{ $submission->registration->teacher->name }} - {{ $submission->registration->workshop->title }}</div>
                </div>

            <!-- Submitted URL -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-400">Submitted URL</label><br />
                <a href="{{ $submission->url }}"
                   class="text-primary-400 hover:text-primary-300 hover:underline break-all"
                   target="_blank">
                    {{ $submission->url }}
                </a>
            </div>

            <!-- PDF File -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-400">PDF Document</label>
                <div class="flex items-center space-x-4">
                    @if($submission->path)
                        <a href="{{ url($submission->path) }}" 
                           class="inline-flex items-center px-3 py-2 bg-primary-600 hover:bg-primary-700 rounded-md text-white text-sm font-medium"
                           target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            View PDF
                        </a>
                    @endif
                </div>
            </div>

            <!-- Status Update Form -->
            <div class="mt-8 p-4 bg-gray-950 rounded-lg border border-gray-800">
                <h4 class="text-md font-medium text-gray-200 mb-4">Update Submission Status</h4>
                
                <form wire:submit.prevent="updateStatus">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-400 mb-2">Status</label>
                            <select id="status" wire:model="state.status" 
                                   class="w-full bg-black border border-gray-700 rounded-md text-gray-950 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                @foreach(App\Enums\ApprovalStatus::cases() as $status)
                                    <option value="{{ $status->value }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="revisionNote" class="block text-sm font-medium text-gray-400 mb-2">Revision Notes</label>
                            <textarea id="revisionNote" wire:model="state.revisionNote" 
                                     class="w-full bg-black border border-gray-700 rounded-md text-gray-950 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                     rows="3"
                                     placeholder="Provide feedback if assignment needs revision"></textarea>
                        </div>
                    </div>
                    
                    <!-- Revision Note (if exists) -->
                    @if($submission->revisionNote)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-400 mb-1">Current Revision Notes</label>
                        <div class="text-gray-200 bg-gray-800 p-3 rounded-md border border-gray-700">
                            {{ $submission->revisionNote }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex justify-end mt-4">
                        <x-filament::button
                            type="submit"
                            color="primary"
                        >
                            Update Status
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-filament-panels::page>