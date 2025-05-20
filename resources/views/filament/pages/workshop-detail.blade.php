<x-filament-panels::page>
    <div class="space-y-4">
        {{-- Workshop Overview --}}
        <x-filament::card class="bg-gray-800">
            @if ($workshop->imageURL)
                <img src="{{ asset($workshop->imageURL) }}" alt="{{ $workshop->title }}" class="w-12 object-cover rounded-md mb-4">
            @endif

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-white">{{ $workshop->title }}</h1>
                <x-filament::badge color="{{ $workshop->isOpen ? 'success' : 'danger' }}">
                    {{ $workshop->isOpen ? 'Open' : 'Closed' }}
                </x-filament::badge>
            </div>

            <p class="text-gray-300 mb-6">{{ $workshop->description }}</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <x-filament::card class="bg-gray-700">
                    <p class="text-sm text-gray-300">Start Date</p>
                    <p class="font-medium text-white">{{ $workshop->startDate->format('F j, Y') }}</p>
                </x-filament::card>
                <x-filament::card class="bg-gray-700">
                    <p class="text-sm text-gray-300">End Date</p>
                    <p class="font-medium text-white">{{ $workshop->endDate->format('F j, Y') }}</p>
                </x-filament::card>
            </div>

            <div class="flex flex-wrap gap-6 text-sm text-gray-300 py-6">
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Price:</span> Rp{{ number_format($workshop->price, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Meets:</span> {{ $workshop->meets->count() }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Assignments:</span> {{ $workshop->assignments->count() }}
                </div>
            </div>

            <x-filament::button
                color="warning"
                tag="a"
                href="{{ route('filament.admin.resources.workshops.edit', $workshop->id) }}"
            >
                Edit Workshop
            </x-filament::button>
        </x-filament::card>

        {{-- Meets Section --}}
        <x-filament::card class="bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-white">Meets</h2>
                <x-filament::button size="sm" icon="heroicon-m-plus" color="primary" tag="a" href="{{ route('filament.admin.resources.meets.create') }}">
                    Add Meet
                </x-filament::button>
            </div>

            <div class="space-y-0">
                @forelse ($workshop->meets as $meet)
                    <a href="{{ route('admin-meets.show', $meet->id) }}">
                        <x-filament::card class="bg-gray-700 border-0 rounded-none">
                            <h3 class="font-bold text-white">{{ $meet->title }}</h3>
                            <p class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($meet->date)->format('F j, Y') }}</p>
                            <p class="text-gray-300 mt-1">{{ $meet->description }}</p>
                        </x-filament::card>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <x-filament::icon name="heroicon-o-calendar" class="w-10 h-10 mb-2 text-gray-400" />
                        <h3 class="text-lg font-medium text-white">No Meets Yet</h3>
                        <p class="text-sm text-gray-300">No meets have been scheduled for this workshop.</p>
                    </div>
                @endforelse
            </div>
        </x-filament::card>

        {{-- Assignments Section --}}
        <x-filament::card class="bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-white">Assignments</h2>
                <x-filament::button size="sm" icon="heroicon-m-plus" color="success" tag="a" href="#">
                    Add Assignment
                </x-filament::button>
            </div>

            <div class="space-y-4">
                @forelse ($workshop->assignments as $assignment)
                    <x-filament::card class="bg-gray-700 border-0 rounded-none">
                        <h3 class="font-bold text-white">{{ $assignment->title }}</h3>
                        <p class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($assignment->date)->format('F j, Y') }}</p>
                        <p class="text-gray-300 mt-1">{{ $assignment->description }}</p>
                    </x-filament::card>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <x-filament::icon name="heroicon-o-calendar" class="w-10 h-10 mb-2 text-gray-400" />
                        <h3 class="text-lg font-medium text-white">No Assignments Yet</h3>
                        <p class="text-sm text-gray-300">No assignments have been made for this workshop.</p>
                    </div>
                @endforelse
            </div>
        </x-filament::card>
    </div>
</x-filament-panels::page>