<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Meet Details --}}
        <x-filament::card class="bg-gray-800">
            <h2 class="text-2xl font-bold text-white mb-4">Meet Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-300">Workshop Title</p>
                    <p class="text-lg font-semibold text-white">{{ $meet->workshop->title }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-300">Meet Title</p>
                    <p class="text-lg font-semibold text-white">{{ $meet->title }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-300">Date</p>
                    <p class="text-lg text-white">{{ \Carbon\Carbon::parse($meet->date)->format('F j, Y') }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-300">Description</p>
                    <p class="text-white">{{ $meet->description ?? 'No description provided.' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <x-filament::button
                    color="warning"
                    tag="a"
                    href="{{ route('filament.admin.resources.meets.edit', $meet->id) }}"
                    icon="heroicon-o-pencil"
                >
                    Edit Meet
                </x-filament::button>
            </div>
        </x-filament::card>

        {{-- Attendance Section --}}
        <x-filament::card class="bg-gray-800">
            <h2 class="text-2xl font-bold text-white mb-4">
                Absensi untuk Peserta <span class="text-primary-500">{{ $workshop->title }}</span>
            </h2>
            
            @if ($registrations->count() > 0)
                <div class="mb-4">
                    <x-filament::button
                        id="mark-all-btn"
                        color="primary"
                        icon="heroicon-o-check-circle"
                        data-meet-id="{{ $meet->id }}"
                    >
                        Mark Present for All
                    </x-filament::button>
                </div>

                <div class="rounded-lg overflow-hidden">
                    <div class="divide-y divide-gray-700">
                        @foreach ($registrations as $registration)
                            @php
                                $presence = $registration->presences->where('meet_id', $meet->id)->first();
                                $isPresent = $presence?->isPresent ?? false;
                                $presenceId = $presence?->id ?? '';
                            @endphp
                            <div class="p-4 flex justify-between items-center bg-gray-700">
                                <div>
                                    <a href="{{ route('filament.admin.resources.teachers.view', $registration->teacher->id) }}" class="hover:underline">
                                        <p class="text-lg font-bold text-white">{{ $registration->teacher->name }}</p>
                                    </a>
                                    <p class="text-sm text-gray-300">{{ $registration->teacher->school->name }}</p>
                                </div>
                                
                                <x-filament::button
                                    id="validate-btn-{{ $registration->teacher->id }}"
                                    class="validate-btn"
                                    color="{{ $isPresent ? 'success' : 'primary' }}"
                                    data-presence-id="{{ $presenceId }}"
                                >
                                    {{ $isPresent ? 'Present' : 'Not Present' }}
                                </x-filament::button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <x-filament::icon name="heroicon-o-user-group" class="w-10 h-10 mb-2 text-gray-400" />
                    <h3 class="text-lg font-medium text-white">No Registrations</h3>
                    <p class="text-sm text-gray-300">Belum ada peserta yang mendaftar pada workshop ini.</p>
                </div>
            @endif
        </x-filament::card>
    </div>

    {{-- Scripts for Presence Functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark individual presence
            document.querySelectorAll('.validate-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const presenceId = this.dataset.presenceId;
                    const url = `/mark-present/${presenceId}`;
                    
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
                            // Use Filament notification if available
                            if (window.Livewire) {
                                window.Livewire.dispatch('notify', {
                                    style: 'success',
                                    message: data.isPresent ? 'Marked as present' : 'Marked as not present',
                                    timeout: 3000
                                });
                            }
                            
                            // Update button color
                            this.classList.remove('fi-btn-success', 'fi-btn-primary');
                            this.classList.add(data.isPresent ? 'fi-btn-success' : 'fi-btn-primary');
                            
                            // Update button text
                            this.textContent = data.isPresent ? 'Present' : 'Not Present';
                        } else {
                            // Show error notification
                            if (window.Livewire) {
                                window.Livewire.dispatch('notify', {
                                    style: 'danger',
                                    message: 'Failed to mark presence',
                                    timeout: 3000
                                });
                            } else {
                                alert('Failed to mark presence.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });
            });

            // Mark all presences
            const markAllBtn = document.querySelector('#mark-all-btn');
            if (markAllBtn) {
                markAllBtn.addEventListener('click', function() {
                    const meetId = this.dataset.meetId;
                    const url = `/mark-all-present/${meetId}`;
                    
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
                            // Use Filament notification if available
                            if (window.Livewire) {
                                window.Livewire.dispatch('notify', {
                                    style: 'success',
                                    message: 'All attendees marked as present',
                                    timeout: 3000
                                });
                            }
                            
                            // Update all buttons
                            document.querySelectorAll('.validate-btn').forEach(btn => {
                                btn.classList.remove('fi-btn-success', 'fi-btn-primary');
                                btn.classList.add(data.isPresent ? 'fi-btn-success' : 'fi-btn-primary');
                                btn.textContent = data.isPresent ? 'Present' : 'Not Present';
                            });
                        } else {
                            // Show error notification
                            if (window.Livewire) {
                                window.Livewire.dispatch('notify', {
                                    style: 'danger',
                                    message: 'Failed to mark all presences',
                                    timeout: 3000
                                });
                            } else {
                                alert('Failed to mark all presences.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });
            }
        });
    </script>
</x-filament-panels::page>