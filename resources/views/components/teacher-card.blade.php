<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-md">
    @props(['teacher'])
    @props(['registration'])
    <a href="">
        <!-- Card Content -->
        <div class="p-5">
            <!-- Workshop Title -->
            <h4 class="text-xl font-bold text-gray-900 mb-2">
                {{ $teacher->name ?? '' }}
            </h4>

            <div class="flex flex-row">
                <p class="text-gray-600 mb-4 line-clamp-3">
                    {{ $registration->regDate->format('F j, Y') ?? '' }}
                </p>
            </div>
        </div>
    </a>
</div>