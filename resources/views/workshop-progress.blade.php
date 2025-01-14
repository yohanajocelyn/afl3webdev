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
                    </tr>
                </thead>
                <tbody>
                    @foreach($workshop->registrations as $registration)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                                {{ $registration->teacher->name }}
                            </td>
                            @foreach($workshop->assignments as $assignment)
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
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
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>