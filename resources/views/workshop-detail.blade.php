<x-layout>
    <section class="bg-gray-100 flex flex-col">
        <div class="flex flex-col items-center px-4 py-10 md:flex-row md:px-10 md:pt-20 md:pb-16">
            {{-- Image --}}
            <div class="">
                <img src="" alt="workshop-image" class=" w-[400px] h-[450px] object-cover rounded-md bg-blue-100">
            </div>
            {{-- details --}}
            <div class="flex flex-col ps-0 md:ps-16 py-3 w-full h-auto md:h-[450px] mt-6 md:mt-0">
                <p class="font-bold text-3xl md:text-5xl text-center md:text-left">{{ $workshop->title }}</p>
                <p class="text-gray-600 py-4 text-center md:text-left">{{ $workshop->description }}</p>
                {{-- <p>Tempat: {{ $workshop->place }}</p> --}}
                <div class="text-center pb-4 md:text-left flex flex-col md:flex-row">
                    <p class="">Tanggal Pelaksanaan: </p>
                    <p class="md:px-2">{{ $workshop['startDate']->format('F j, Y') }} - {{ $workshop['endDate']->format('F j, Y') }}</p>
                </div>
                <p class="text-center md:text-left">Registration Fee:</p>
                <p class="text-center md:text-left pb-4">Rp {{ number_format($workshop['price'], 0, ',', '.') }}</p>
                {{-- Register Button --}}
                <div class="mt-auto flex justify-end">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md">
                        Register
                    </button>
                </div>
            </div>
        </div>

        {{-- bottom part (the tugas / meets) --}}
        {{-- i think bisa di-loop --}}
        <div class="mb-20">
            <p class="font-semibold text-2xl pb-4">Meets</p>
            <div class="bg-white shadow-md p-2 rounded-md">
                <p>Meets</p>
                <p>Tuesday, 15 December 2030</p>
            </div>
        </div>

    </section>
</x-layout>