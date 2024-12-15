<footer class="container mx-auto px-4 pt-8 pb-4">
    <div class="bg-white rounded-xl shadow-2xl p-8 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo and Brand Section -->
            <div>
                <img 
                    src="{{ asset('images/logo-bebras-cropped.png') }}" 
                    alt="Workshop Platform Logo" 
                    class="w-64 h-auto mb-4"
                >
            </div>

            <!-- Contact Information -->
            <div>
                <h4 class="text-xl font-bold text-gray-900 mb-4">Contact Us</h4>
                <div class="space-y-3">
                    <div class="flex flex-row items-start text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="flex flex-col">
                            <span>CitraLand CBD Boulevard, Made, Kec. Sambikerep,</span>
                            <span>Surabaya, Jawa Timur, 60219</span>
                        </div>
                        
                    </div>
                    
                    <div class="flex items-center text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="http://bit.ly/ucb-info" target="_blank" class="hover:text-green-600 transition">
                            http://bit.ly/ucb-info
                        </a>
                    </div>
                    
                    <div class="flex items-center text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:admin@bebras.uc.ac.id" class="hover:text-red-600 transition">
                            admin@bebras.uc.ac.id
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-xl font-bold text-gray-900 mb-4">Quick Links</h4>
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="block text-gray-600 hover:text-blue-600 transition">Home</a>
                    <a href="{{ route('workshops') }}" class="block text-gray-600 hover:text-blue-600 transition">Workshops</a>
                    <a href="{{ route('about') }}" class="block text-gray-600 hover:text-blue-600 transition">About Us</a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 pt-6 border-t border-gray-200 text-center text-gray-500">
            © {{ date('Y') }} Workshop Platform. All Rights Reserved.
        </div>
    </div>
</footer>