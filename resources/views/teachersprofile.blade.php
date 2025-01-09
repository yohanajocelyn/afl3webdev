<x-layout>
    <section class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
        {{-- box --}}
        <div class="bg-white shadow-lg rounded-lg p-8 w-full space-y-10">
            {{-- profile --}}
            <div class="flex flex-row items-center space-x-10">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-48 h-48 bg-gray-300 rounded-full overflow-hidden">
                        <img src="{{ asset($teacher['pfpURL']) }}" alt="Profile Picture" class="object-cover w-full h-full">
                    </div>
                </div>

                {{-- profile details --}}
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-6">Teacher's Profile</h1>
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['name'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['gender'] }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['email'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['phone_number'] }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">School</label>
                                <a href="/teacherslist?schoolId={{ $teacher['school']['id'] }}" class="mt-1 text-gray-900">{{ $teacher['school']['name'] }}</a>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Subject Taught</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['subjectTaught'] }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:space-x-6">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">NUPTK</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['nuptk'] }}</p>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Community</label>
                                <p class="mt-1 text-gray-900">{{ $teacher['community'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Workshop and Assignments buttons --}}
            <div class="flex justify-start space-x-6 mb-6">
                <button id="workshopsButton" class="border-2 border-blue-500 text-blue-500 px-6 py-2 rounded-full hover:bg-blue-500 hover:text-white" onclick="toggleSection('workshops')">
                    Workshops
                </button>
                <button id="assignmentsButton" class="border-2 border-purple-500 text-purple-500 px-6 py-2 rounded-full hover:bg-purple-600 hover:text-white" onclick="toggleSection('assignments')">
                    Assignments
                </button>
            </div>

            {{-- Workshop Section --}}
            <div id="workshopsSection" class="hidden">
                <h2 class="text-2xl font-bold mb-6">Workshops</h2>
                <div class="flex space-x-4 mb-6">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600" disabled>
                        Find Workshops
                    </button>
                    <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600" disabled>
                        Joined
                    </button>
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded-full hover:bg-yellow-600" disabled>
                        Pending
                    </button>
                    <button class="bg-gray-500 text-white px-4 py-2 rounded-full hover:bg-gray-600" disabled>
                        History
                    </button>
                </div>
                <p class="text-gray-700">Manage and explore your workshops here.</p>
            </div>

            {{-- Assignments Section --}}
            <div id="assignmentsSection" class="hidden">
                <h2 class="text-2xl font-bold mb-6">Assignments</h2>
                <div class="flex space-x-4 mb-6">
                    <button class="bg-purple-500 text-white px-4 py-2 rounded-full hover:bg-purple-600" disabled>
                        Ongoing
                    </button>
                </div>
                <p class="text-gray-700">Track your ongoing assignments here.</p>
            </div>
        </div>
    </section>

    <script>
        function toggleSection(section) {
            // Hide both sections by default
            document.getElementById('workshopsSection').classList.add('hidden');
            document.getElementById('assignmentsSection').classList.add('hidden');
            
            // Reset button styles biar transparent n ada border
            document.getElementById('workshopsButton').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('workshopsButton').classList.add('border-2', 'border-blue-500', 'text-blue-500');
            document.getElementById('assignmentsButton').classList.remove('bg-purple-500', 'text-white');
            document.getElementById('assignmentsButton').classList.add('border-2', 'border-purple-500', 'text-purple-500');

            // Show the selected section
            if (section === 'workshops') {
                document.getElementById('workshopsSection').classList.remove('hidden');
                document.getElementById('workshopsButton').classList.add('bg-blue-500', 'text-white');
                document.getElementById('workshopsButton').classList.remove('border-2', 'border-blue-500', 'text-blue-500');
            } else if (section === 'assignments') {
                document.getElementById('assignmentsSection').classList.remove('hidden');
                document.getElementById('assignmentsButton').classList.add('bg-purple-500', 'text-white');
                document.getElementById('assignmentsButton').classList.remove('border-2', 'border-purple-500', 'text-purple-500');
            }
        }

        //workshops section by default
        toggleSection('workshops');
    </script>
</x-layout>
