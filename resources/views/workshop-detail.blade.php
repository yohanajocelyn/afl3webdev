<x-layout>
    <section class="bg-gray-100 flex flex-col md:px-40">
        <div class="flex flex-col items-center px-auto py-10 md:flex-row md:pt-20 md:pb-16">
            {{-- Image --}}
            <div>
                <img src="" alt="workshop-image" class="w-[370px] h-[450px] object-cover rounded-md bg-blue-100">
            </div>
            {{-- details --}}
            <div class="flex flex-col ps-16 py-3 w-full h-[450px]">
                <p class="font-bold text-5xl">{{ $workshop->title }}</p>
                <p class="text-gray-600 py-4">{{$workshop->description}}</p>
                <p>Tempat</p>
                <p>Tanggal dan Waktu</p>
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
