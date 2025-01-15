<x-layout>

    <section class="h-min-screen flex items-center justify-center flex-col">
        <div class="container w-full bg-gray-100 mx-auto my-8">
            <h1 class="text-3xl font-bold mb-4">Upload Workshop</h1>
    
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
    
                {{-- Workshop Title --}}
                <div class="mb-4">
                    <label for="title" class="block text-sm font-bold mb-2">Workshop Title</label>
                    <input type="text" name="title" id="title" class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" placeholder="Enter workshop title" required>
                </div>
    
                {{-- Description --}}
                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" placeholder="Enter workshop description" required></textarea>
                </div>
    
                {{-- Start Date --}}
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-bold mb-2">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" required>
                </div>
    
                {{-- End date --}}
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-bold mb-2">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" required>
                </div>
    
                {{-- Price --}}
                <div class="mb-4">
                    <label for="price" class="block text-sm font-bold mb-2">Price ($)</label>
                    <input type="number" name="price" id="price" class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" placeholder="Enter workshop price" step="0.01" required>
                </div>
    
                {{-- file --}}
                <div class="mb-4">
                    <label for="workshop_image" class="block text-sm font-bold mb-2">Upload File</label>
                    <input type="file" name="workshop_image" id="workshop_image" class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
                </div>
    
                {{-- Submit --}}
                <div class="text-right">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">Upload Workshop</button>
                </div>
            </form>
        </div>
    </section>
</x-layout>
