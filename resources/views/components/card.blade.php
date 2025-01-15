<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-md 
            transform transition duration-300 hover:scale-105 hover:shadow-xl 
            cursor-pointer group">
    @props(['workshop'])
    <a href="{{ route('workshop-detail', $workshop) }}" class="h-full flex flex-col">
        <!-- Promotional Image -->
        <div class="relative w-full pt-[56.25%]"> <!-- 16:9 Aspect Ratio -->
            <img 
                src="{{ asset($workshop->imageURL) }}" 
                alt="Lorem"
                class="absolute top-0 left-0 w-full h-full object-cover"
            >
        </div>

        <!-- Card Content -->
        <div class="flex flex-col p-5 flex-grow">
            <!-- Workshop Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2 
                       group-hover:text-blue-600 transition duration-300">
                {{ $workshop->title }}
            </h3>

            <!-- Short Description -->
            <p class="text-gray-600 mb-4 line-clamp-3">
                {{ $workshop->description }}
            </p>

            <!-- Price Information -->
            <div class="flex justify-between items-center mt-auto">
                <div class="text-gray-900 font-semibold text-lg">
                    @if( $workshop->price == 0 )
                        <span class="text-green-600">Gratis</span>
                    @else
                        <span>
                        Rp. {{ number_format($workshop->price, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Additional Info Badge -->
                <div class="text-sm text-gray-500 flex items-center space-x-2">
                    <span>
                        {{ $workshop->duration }} hari
                    </span>
                </div>
            </div>
        </div>
    </a>
</div>