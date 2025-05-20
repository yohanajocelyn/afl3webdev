<x-layout>
    <section class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
        {{-- box --}}
        <div class="bg-white shadow-lg rounded-lg p-8 w-3/4 space-y-10">
            {{-- profile --}}
            <div class="flex flex-row items-center space-x-10">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-48 h-48 bg-gray-300 rounded-full overflow-hidden">
                        <img src="{{ asset($teacher['pfpURL']) }}" alt="Profile Picture"
                            class="object-cover w-full h-full">
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
                                <p class="mt-1 text-gray-900">{{ $teacher['school']['name'] }}</p>
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
                <button id="workshopsButton"
                    class="border-2 border-blue-500 text-blue-500 px-6 py-2 rounded-full hover:bg-blue-500 hover:text-white"
                    onclick="toggleSection('workshops')">
                    Workshops
                </button>
                <button id="assignmentsButton"
                    class="border-2 border-purple-500 text-purple-500 px-6 py-2 rounded-full hover:bg-purple-500 hover:text-white"
                    onclick="toggleSection('assignments')">
                    Assignments
                </button>
            </div>

            {{-- Workshop Section --}}
            <div id="workshopsSection" class="hidden">
                <h2 class="text-2xl font-bold mb-6">Workshops</h2>
                <div class="flex space-x-4 mb-6">
                    <button onclick="showWorkshopCategory('joined')" id="joinedButton"
                        class="border-2 border-green-500 text-green-500 px-4 py-2 rounded-full hover:bg-green-500 hover:text-white">
                        Joined
                    </button>
                    <button onclick="showWorkshopCategory('pending')" id="pendingButton"
                        class="border-2 border-yellow-500 text-yellow-500 px-4 py-2 rounded-full hover:bg-yellow-500 hover:text-white">
                        Pending
                    </button>
                    <button onclick="showWorkshopCategory('history')" id="historyButton"
                        class="border-2 border-gray-500 text-gray-500 px-4 py-2 rounded-full hover:bg-gray-500 hover:text-white">
                        History
                    </button>
                </div>
                <p class="text-gray-700">Manage and explore your workshops here.</p>
                <div id="joinedWorkshops" class="hidden">
                    @foreach ($joinedWorkshops as $registration)
                        <div class="border rounded p-4 mb-2 bg-green-100">
                            <strong>
                                <a href="{{ route('workshop-detail', ['id' => $registration->workshop->id]) }}"
                                    class="text-green-700 hover:text-green-900 hover:underline transition-colors duration-200">
                                    {{ $registration->workshop->title }}
                                </a>
                            </strong><br>
                            {{ $registration->workshop->description ?? 'No description.' }}
                        </div>
                    @endforeach
                </div>
                <div id="pendingWorkshops" class="hidden">
                    @foreach ($pendingWorkshops as $registration)
                        <div class="border rounded p-4 mb-2 bg-yellow-100">
                            <strong>
                                <a href="{{ route('workshop-detail', ['id' => $registration->workshop->id]) }}"
                                    class="text-yellow-700 hover:text-yellow-900 hover:underline transition-colors duration-200">
                                    {{ $registration->workshop->title }}
                                </a>
                            </strong><br>
                            {{ $registration->workshop->description ?? 'No description.' }}
                        </div>
                    @endforeach
                </div>
                <div id="historyWorkshops" class="hidden">
                    @foreach ($historyWorkshops as $registration)
                        <div class="border rounded p-4 mb-2 bg-gray-100">
                            <strong>
                                <a href="{{ route('workshop-detail', ['id' => $registration->workshop->id]) }}"
                                    class="text-gray-700 hover:text-gray-900 hover:underline transition-colors duration-200">
                                    {{ $registration->workshop->title }}
                                </a>
                            </strong><br>
                            {{ $registration->workshop->description ?? 'No description.' }}
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Assignments Section --}}
            <div id="assignmentsSection" class="hidden">
                <h2 class="text-2xl font-bold mb-6">Assignments</h2>
                <div class="flex space-x-4 mb-6">
                    <button onclick="showAssignmentCategory('ongoing')" id="ongoingButton"
                        class="border-2 border-purple-500 text-purple-500 px-4 py-2 rounded-full hover:bg-purple-500 hover:text-white">
                        Ongoing
                    </button>
                    <button onclick="showAssignmentCategory('done')" id="doneButton"
                        class="border-2 border-green-500 text-green-500 px-4 py-2 rounded-full hover:bg-green-500 hover:text-white">
                        Done
                    </button>
                    <button onclick="showAssignmentCategory('approved')" id="approvedButton"
                        class="border-2 border-blue-500 text-blue-500 px-4 py-2 rounded-full hover:bg-blue-500 hover:text-white">
                        Approved
                    </button>
                </div>
                <p class="text-gray-700">Track your ongoing assignments here.</p>
                <div id="ongoingAssignments" class="hidden">
                    @foreach ($ongoingAssignments as $assignment)
                        <div class="border rounded p-4 mb-2 bg-purple-100">
                            <strong>
                                <a href="{{ route('assignment-detail', ['assignmentId' => $assignment->id]) }}"
                                    class="text-purple-700 hover:text-purple-900 hover:underline transition-colors duration-200">
                                    {{ $assignment->title }}
                                </a>
                            </strong><br>
                            {{ $assignment->description ?? 'No description.' }}
                        </div>
                    @endforeach
                </div>

                <div id="doneAssignments" class="hidden">
                    @foreach ($doneAssignments as $assignment)
                        <div class="border rounded p-4 mb-2 bg-green-100">
                            <strong>
                                <a href="{{ route('assignment-detail', ['assignmentId' => $assignment->id]) }}"
                                    class="text-green-700 hover:text-green-900 hover:underline transition-colors duration-200">
                                    {{ $assignment->title }}
                                </a>
                            </strong><br>
                            {{ $assignment->description ?? 'No description.' }}
                        </div>
                    @endforeach
                </div>

                <div id="approvedAssignments" class="hidden">
                    @foreach ($approvedAssignments as $assignment)
                        <div class="border rounded p-4 mb-2 bg-blue-100">
                            <strong>
                                <a href="{{ route('assignment-detail', ['assignmentId' => $assignment->id]) }}"
                                    class="text-blue-700 hover:text-blue-900 hover:underline transition-colors duration-200">
                                    {{ $assignment->title }}
                                </a>
                            </strong><br>
                            {{ $assignment->description ?? 'No description.' }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleSection(section) {
            // Hide both sections
            document.getElementById('workshopsSection').classList.add('hidden');
            document.getElementById('assignmentsSection').classList.add('hidden');

            // Reset main section buttons
            document.getElementById('workshopsButton').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('workshopsButton').classList.add('border-2', 'border-blue-500', 'text-blue-500');
            document.getElementById('assignmentsButton').classList.remove('bg-purple-500', 'text-white');
            document.getElementById('assignmentsButton').classList.add('border-2', 'border-purple-500', 'text-purple-500');

            // Show selected section
            if (section === 'workshops') {
                document.getElementById('workshopsSection').classList.remove('hidden');
                document.getElementById('workshopsButton').classList.add('bg-blue-500', 'text-white');
                document.getElementById('workshopsButton').classList.remove('border-2', 'border-blue-500', 'text-blue-500');
            } else if (section === 'assignments') {
                document.getElementById('assignmentsSection').classList.remove('hidden');
                document.getElementById('assignmentsButton').classList.add('bg-purple-500', 'text-white');
                document.getElementById('assignmentsButton').classList.remove('border-2', 'border-purple-500',
                    'text-purple-500');
            }
        }

        function showWorkshopCategory(category) {
            // Hide all category sections
            const categories = ['joined', 'pending', 'history'];
            categories.forEach(cat => {
                const section = document.getElementById(cat + 'Workshops');
                if (section) section.classList.add('hidden');

                const button = document.getElementById(cat + 'Button');
                if (button) {
                    button.classList.remove('bg-' + getColor(cat) + '-500', 'text-white');
                    button.classList.add('border-2', 'border-' + getColor(cat) + '-500', 'text-' + getColor(cat) +
                        '-500');
                }
            });

            // Show selected section and highlight button
            const selectedSection = document.getElementById(category + 'Workshops');
            if (selectedSection) selectedSection.classList.remove('hidden');

            const selectedButton = document.getElementById(category + 'Button');
            if (selectedButton) {
                selectedButton.classList.add('bg-' + getColor(category) + '-500', 'text-white');
                selectedButton.classList.remove('border-2', 'border-' + getColor(category) + '-500', 'text-' + getColor(
                    category) + '-500');
            }
        }

        function getColor(category) {
            switch (category) {
                case 'joined':
                    return 'green';
                case 'pending':
                    return 'yellow';
                case 'history':
                    return 'gray';
                default:
                    return 'blue';
            }
        }

        function showAssignmentCategory(category) {
            const categories = ['ongoing', 'done', 'approved'];
            categories.forEach(cat => {
                const section = document.getElementById(cat + 'Assignments');
                if (section) section.classList.add('hidden');

                const button = document.getElementById(cat + 'Button');
                if (button) {
                    button.classList.remove('bg-' + getAssignmentColor(cat) + '-500', 'text-white');
                    button.classList.add('border-2', 'border-' + getAssignmentColor(cat) + '-500', 'text-' +
                        getAssignmentColor(cat) + '-500');
                }
            });

            const selectedSection = document.getElementById(category + 'Assignments');
            if (selectedSection) selectedSection.classList.remove('hidden');

            const selectedButton = document.getElementById(category + 'Button');
            if (selectedButton) {
                selectedButton.classList.add('bg-' + getAssignmentColor(category) + '-500', 'text-white');
                selectedButton.classList.remove('border-2', 'border-' + getAssignmentColor(category) + '-500', 'text-' +
                    getAssignmentColor(category) + '-500');
            }
        }

        function getAssignmentColor(category) {
            switch (category) {
                case 'ongoing':
                    return 'purple';
                case 'done':
                    return 'green';
                case 'approved':
                    return 'blue';
                default:
                    return 'gray';
            }
        }

        // Default load
        document.addEventListener('DOMContentLoaded', function() {
            toggleSection('workshops');
            showWorkshopCategory('joined');
            showAssignmentCategory('ongoing');
        });
    </script>
</x-layout>
