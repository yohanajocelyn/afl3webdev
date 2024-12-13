<x-layout>
    <x-slot:state>{{ $state }}</x-slot:state>
    <section class="bg-gray-100 h-screen flex items-center justify-center flex-col">
        {{-- <!-- Toggle Links -->
            <div class="flex justify-between mb-6">
                <a href="?form=register" 
                   class="w-1/2 text-center py-2 text-white font-semibold rounded-l-md 
                          {{ request('form') === 'register'  ? 'bg-green-500' : 'bg-gray-200 text-gray-600' }}">
                    Register
                </a>
                <a href="?form=login" 
                   class="w-1/2 text-center py-2 text-white font-semibold rounded-r-md 
                          {{ request('form') === 'login'|| !request('form') ? 'bg-blue-500' : 'bg-gray-200 text-gray-600' }}">
                    Login
                </a>
            </div> --}}
        <div class="w-full max-w-md bg-white shadow-lg rounded-md p-8">
            
    
            <!-- Conditional Forms -->
            @if(request('form') === 'register')
                <form method="POST" action="/register" class="space-y-4">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-700">Register</h2>
                    <div class="flex flex-col">
                        <label for="name" class="text-sm font-medium text-gray-600">Name</label>
                        <input id="name" name="name" type="text" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Enter your name" required />
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input id="email" name="email" type="email" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Enter your email" required />
                    </div>
                    <div class="flex flex-col">
                        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                        <input id="password" name="password" type="password" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Create a password" required />
                    </div>
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Register</button>
                </form>
            @elseif(request('form') === 'login' || !request('form'))
                <form method="POST" action="/login" class="space-y-4">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-700">Login</h2>
                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input id="email" name="email" type="email" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Enter your email" required />
                    </div>
                    <div class="flex flex-col">
                        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                        <input id="password" name="password" type="password" class="border rounded-md p-2 focus:outline-blue-400" placeholder="Enter your password" required />
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Login</button>
                </form>
            @endif
        </div>
    </section>
</x-layout>
