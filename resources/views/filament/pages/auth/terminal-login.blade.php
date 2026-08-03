<div class="fixed inset-0 bg-gray-900 flex items-center justify-center p-4 antialiased selection:bg-green-500/30">
    @vite('resources/css/app.css')
    <div class="w-full max-w-2xl bg-secondary rounded-lg shadow-2xl border border-gray-700 flex flex-col overflow-hidden relative z-10">
        <!-- Terminal Header -->
        <div class="h-8 bg-gray-800 flex items-center px-4 border-b border-gray-900">
            <div class="flex space-x-2">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
            </div>
            <div class="mx-auto text-xs text-gray-400 font-mono">admin@danang-os: ~</div>
        </div>

        <!-- Terminal Content -->
        <div class="p-6 font-mono text-sm text-gray-300">
            <div class="mb-6">
                DanangOS Admin System (v2.0.0)<br>
                Authentication required.
            </div>

            <!-- Custom Form using Livewire -->
            <form wire:submit="authenticate" class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center">
                    <span class="text-green-400 mr-2 w-28">User/Email:</span>
                    <input wire:model="data.login" type="text" class="bg-transparent border-b border-gray-700 outline-none text-white flex-1 py-1 focus:border-green-400 focus:ring-0" autofocus required autocomplete="username">
                </div>
                @error('data.login') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror

                <div class="flex flex-col sm:flex-row sm:items-center mt-4">
                    <span class="text-green-400 mr-2 w-28">Password:</span>
                    <input wire:model="data.password" type="password" class="bg-transparent border-b border-gray-700 outline-none text-white flex-1 py-1 focus:border-green-400 focus:ring-0" required autocomplete="current-password">
                </div>
                @error('data.password') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror

                <div class="flex items-center mt-6 pt-4">
                    <span class="text-green-400 mr-2">admin@danang-os:~$</span>
                    <button type="submit" class="text-white hover:text-green-400 transition-colors focus:outline-none focus:text-green-400">
                        ./login.sh
                        <span class="animate-pulse">_</span>
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-xs text-gray-600">
                <a href="/" class="hover:text-gray-400">cd /home</a>
            </div>
        </div>
    </div>
</div>
