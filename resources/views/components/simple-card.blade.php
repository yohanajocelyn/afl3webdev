<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-md">
    <a href="{{ $url ?? '' }}">
        <!-- Card Content -->
        <div class="p-5">
            <!-- Workshop Title -->
            <h4 class="text-xl font-bold text-gray-900 mb-2">
                {{ $title ?? '' }}
            </h4>

            <p class="text-gray-600 mb-4 line-clamp-3">
                {{ $date ?? '' }}
            </p>
        </div>
    </a>
</div>