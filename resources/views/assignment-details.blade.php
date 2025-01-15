<x-layout>
    <div class="bg-gray-100 my-8 p-6">
        {{-- Title --}}
        <h1 class="text-3xl font-bold mb-4">{{ $assignment['title'] }}</h1>

        {{-- Date --}}
        <p class="text-gray-700 mb-6">deadline: {{ $assignment['date'] }}</p>

        {{-- Description --}}
        <p class="text-gray-700 mb-6">{{ $assignment['description'] }}</p>

        <div class="border-t border-gray-300 mt-6 pt-4">
            @if (auth()->check() && auth()->user()->role === \App\Enums\Role::Admin)
                {{-- Admin View --}}
                <div class="flex justify-end">
                    <button 
                        id="editAssignmentButton" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-md">
                        Edit Assignment
                    </button>
                </div>

                {{-- Modal --}}
                <div 
                    id="editAssignmentModal" 
                    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
                        <h2 class="text-2xl font-bold mb-4">Edit Assignment</h2>

                        <form action="{{ route('edit-assignment') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
                                <input 
                                    type="text" 
                                    id="title" 
                                    name="title" 
                                    value="{{ $assignment['title'] }}" 
                                    class="border rounded-lg px-3 py-2 w-full" 
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 font-bold mb-2">Date:</label>
                                <input 
                                    type="date" 
                                    id="date" 
                                    name="date" 
                                    value="{{ $assignment['date'] }}" 
                                    class="border rounded-lg px-3 py-2 w-full" 
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 font-bold mb-2">Description:</label>
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    class="border rounded-lg px-3 py-2 w-full" 
                                    required>{{ $assignment['description'] }}</textarea>
                            </div>
                            <input id="assignmentId" name="assignmentId" type="hidden" value="{{ $assignment['id'] }}">
                            <div class="flex justify-end">
                                <button 
                                    type="button" 
                                    id="closeModalButton" 
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">
                                    Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    document.getElementById('editAssignmentButton').addEventListener('click', function() {
                        document.getElementById('editAssignmentModal').classList.remove('hidden');
                    });

                    document.getElementById('closeModalButton').addEventListener('click', function() {
                        document.getElementById('editAssignmentModal').classList.add('hidden');
                    });
                </script>
            @else
                {{-- User View --}}
                <h3 class="text-lg font-bold mb-4">Submit Your Work</h3>
                <form action="{{ route('submit-assignment', ['id' => $assignment->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="block text-gray-700 font-bold mb-2">Upload File:</label>
                        <input type="file" id="file" name="file" class="border rounded-lg px-3 py-2 w-full" required>
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Submit</button>
                </form>
            @endif
        </div>
    </div>
</x-layout>
