<x-layout>
    <x-slot:state></x-slot:state>
    <section class="bg-gray-100 min-h-screen flex flex-col items-center py-10">
        {{-- box --}}
        <div class="bg-white shadow-lg rounded-lg p-8 w-3/4 space-y-10">
            {{-- profile --}}
            <div class="flex flex-row items-center space-x-10">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-48 h-48 bg-gray-300 rounded-full overflow-hidden">
                        <img src="path-to-profile-picture.jpg" alt="Profile Picture" class="object-cover w-full h-full">
                    </div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Change Picture
                    </button>
                </div>

                {{-- form detail --}}
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-6">Edit Profile</h1>
                    <form action="/profile/update" method="POST" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="border-gray-300">

            {{-- Workshop --}}
            <div>
                <h2 class="text-2xl font-bold mb-6">Workshops</h2>
                <div class="flex space-x-4 mb-6">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">
                        Find Workshops
                    </button>
                    <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">
                        Joined
                    </button>
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded-full hover:bg-yellow-600">
                        Pending
                    </button>
                    <button class="bg-gray-500 text-white px-4 py-2 rounded-full hover:bg-gray-600">
                        History
                    </button>
                </div>
                <p class="text-gray-700">Manage and explore your workshops here.</p>
            </div>

            <hr class="border-gray-300">

            {{-- Assignments --}}
            <div>
                <h2 class="text-2xl font-bold mb-6">Assignments</h2>
                <div class="flex space-x-4 mb-6">
                    <button class="bg-purple-500 text-white px-4 py-2 rounded-full hover:bg-purple-600">
                        Ongoing
                    </button>
                </div>
                <p class="text-gray-700">Track your ongoing assignments here.</p>
            </div>
        </div>
    </section>
</x-layout>
