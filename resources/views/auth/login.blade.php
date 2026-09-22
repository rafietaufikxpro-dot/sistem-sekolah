<x-guest-layout>
    
        <!-- Form Header -->
        <div class="mb-8">
            <h3 class="font-serif text-2xl font-bold text-navy-900 tracking-tight">
                Selamat Datang Kembali
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Silakan masuk menggunakan email dan kata sandi Anda.
            </p>
        </div>

        <!-- Session Status Alert -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700 flex items-center space-x-3">
                <svg class="w-5 h-5 shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-700 mb-1.5">
                    Alamat Email
                </label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="contoh@sekolah.sch.id"
                        class="block w-full pl-11 pr-4 py-3 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                    />
                </div>
                @if ($errors->has('email'))
                    <p class="mt-1.5 text-xs text-red-600 font-medium">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <!-- Password with Eye Toggle -->
            <div x-data="{ showPassword: false }">
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">
                        Kata Sandi
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs text-navy-700 hover:underline font-medium" href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input 
                        id="password" 
                        :type="showPassword ? 'text' : 'password'" 
                        name="password" 
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••"
                        class="block w-full pl-11 pr-11 py-3 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                    />
                    <button 
                        type="button" 
                        @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                    >
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.022 10.022 0 013.122-.443c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.072 3.864m-4.577 2.127A3 3 0 019.879 9.879M6.343 6.343l11.314 11.314"/>
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <p class="mt-1.5 text-xs text-red-600 font-medium">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember"
                    class="w-4 h-4 rounded border-gray-300 text-navy-700 focus:ring-navy-700/20"
                >
                <label for="remember_me" class="ml-2.5 text-sm text-gray-600 select-none">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-navy-900 hover:bg-navy-700 active:bg-navy-900 text-white font-medium text-sm rounded-lg shadow-lg shadow-navy-900/15 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-700 transition-all duration-150 flex items-center justify-center space-x-2"
                >
                    <span>Masuk ke Portal</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Divider & Link to Register -->
        @if (Route::has('register'))
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">
                    Belum memiliki akun siswa? 
                    <a href="{{ route('register') }}" class="font-semibold text-navy-900 hover:underline">
                        Daftar Siswa Mandiri &rarr;
                    </a>
                </p>
            </div>
        @endif
    </div>
</x-guest-layout>

