<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-md 
            transform transition duration-300 hover:scale-105 hover:shadow-xl 
            cursor-pointer group">
    <a href="">
        <!-- Promotional Image -->
        <div class="relative w-full pt-[56.25%]"> <!-- 16:9 Aspect Ratio -->
            <img 
                src="" 
                alt="Lorem"
                class="absolute top-0 left-0 w-full h-full object-cover"
            >
        </div>

        <!-- Card Content -->
        <div class="p-5">
            <!-- Workshop Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2 
                       group-hover:text-blue-600 transition duration-300">
                {{-- {{ $workshop->title }} --}}
                Placeholder Title
            </h3>

            <!-- Short Description -->
            <p class="text-gray-600 mb-4 line-clamp-3">
                {{-- {{ $workshop->short_description }} --}}
                Lorem ipsum
            </p>

            <!-- Price Information -->
            <div class="flex justify-between items-center">
                <div class="text-gray-900 font-semibold text-lg">
                    @if(true)
                        <span class="text-green-600">Free</span>
                    @else
                        <span>
                            {{-- ${{ number_format($workshop->price, 2) }} --}}
                            $200
                        </span>
                    @endif
                </div>

                <!-- Additional Info Badge -->
                <div class="text-sm text-gray-500 flex items-center space-x-2">
                    <span>
                        {{-- {{ $workshop->duration }} --}} 2
                        Hours
                    </span>
                </div>
            </div>
        </div>
    </a>
</div>