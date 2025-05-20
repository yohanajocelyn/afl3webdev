<x-admin-layout>
<div class="max-w-2xl mx-auto py-10">
    <form method="POST" action="{{ $meet ? route('admin-meets.update', $meet->id) : route('admin-meets.store') }}">
        @csrf
        @if($meet)
            @method('PUT')
        @endif

        <input type="hidden" name="workshop_id" value="{{ old('workshop_id', $meet->workshop_id ?? $workshop->id) }}">

        <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input type="text" name="title" value="{{ old('title', $meet->title ?? '') }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Date</label>
            <input type="date" name="date" value="{{ old('date', isset($meet) ? \Carbon\Carbon::parse($meet->date)->format('Y-m-d') : '') }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $meet->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ $meet ? 'Update Meet' : 'Create Meet' }}
        </button>
    </form>
</div>
</x-admin-layout>
