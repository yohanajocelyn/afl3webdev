<x-layout>
    <x-slot:state>{{ $state }}</x-slot:state>
    <section class="bg-gray-100 flex flex-col md:px-40">
        <div class="flex flex-col items-center px-auto py-10 md:flex-row md:pt-20 md:pb-16">
            {{-- Image --}}
            <div>
                <img src="" alt="workshop-image" class="w-[370px] h-[450px] object-cover rounded-md bg-blue-100">
            </div>
            {{-- details --}}
            <div class="flex flex-col ps-16 py-3 w-full h-[450px]">
                <p class="font-bold text-5xl">Workshop Title</p>
                <p class="text-gray-600 py-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Accusamus
                    eligendi labore exercitationem
                    nihil nisi ullam praesentium, laborum, autem laudantium dolorem dicta nemo quisquam assumenda
                    possimus culpa fuga tenetur eveniet at.</p>
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
        {{-- kl admin bisa lihat list of teachers joined --}}
        <div class="mb-20">
            <p class="font-semibold text-2xl pb-4">Meets</p>
            <div class="bg-white shadow-md p-2 rounded-md">
                <p>Meets</p>
                <p>Tuesday, 15 December 2030</p>
            </div>
        </div>

    </section>
</x-layout>
