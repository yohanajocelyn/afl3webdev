<x-layout>
    <x-slot:state>Teachers List</x-slot:state>

    <div class="container mx-auto m-8">
        <h1 class="text-3xl font-bold mb-4">Teachers</h1>

        <div class="p-6 bg-gray-100 rounded-lg shadow-lg">
            <ul class="divide-y divide-gray-300">
                <li>
                    @foreach ($teachers as $teacher)
                        <a href="{{ $teacher['id'] }}" class=" p-4 hover:bg-blue-50 flex justify-between items-center">
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
                <li>
                    <a href="#" class=" p-4 hover:bg-blue-50 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-bold">Jane Smith</p>
                            <p class="text-sm text-gray-600">Riverside Elementary</p>
                        </div>
                        <div class="text-blue-600 text-xl">
                            &#8250;
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="p-4 hover:bg-blue-50 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-bold">Emily Johnson</p>
                            <p class="text-sm text-gray-600">Greenwood Academy</p>
                        </div>
                        <div class="text-blue-600 text-xl">
                            &#8250;
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</x-layout>
