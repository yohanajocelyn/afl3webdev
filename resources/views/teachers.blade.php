<x-layout>
    <div class="bg-gray-100 my-8">
        @if (request('schoolId'))
            <p>{{ $school['name'] }}</p>
            <p>{{ $school['address']}}, {{ $school['city'] }}</p>
        @endif
        <h1 class="text-3xl font-bold mb-4">Teachers</h1>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <!-- Sort by dropdown -->
            <div class="flex-1 sm:mr-4 mb-4 sm:mb-0">
                <label for="sortBy" class="sr-only">Sort by</label>
                <select id="sortBy" class="border p-2 rounded-md w-full sm:w-auto focus:outline-blue-400">
                    <option value="name" selected>Sort by Name</option>
                    <option value="school">Sort by School</option>
                    <option value="subject">Sort by Workshop</option>
                    <option value="email">Sort by Assignments</option>
                </select>
            </div>

            <!-- Search bar on the right for large screens, on top for small screens -->
            <div class="flex w-auto">
                <input type="text" placeholder="Search teachers..." class="border p-2 rounded-md w-full sm:w-64 focus:outline-blue-400" />
                <button class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Search
                </button>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-lg">
            <ul class="divide-y divide-gray-300">
                <li>
                    @if (count($teachers) == 0)
                        <p>no teachers</p>
                    @endif
                    @foreach ($teachers as $teacher)
                        <a href="/teacherprofile/?teacherId={{ $teacher['id'] }}" class="p-4 hover:bg-blue-50 flex justify-between items-center">
                            <div>
                                <p class="text-lg font-bold">{{ $teacher['name'] }}</p>
                                <p class="text-sm text-gray-600">{{ $teacher['school']['name'] }}</p>
                            </div>
                            <div class="text-blue-600 text-xl">
                                &#8250;
                            </div>
                        </a>
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
</x-layout>
