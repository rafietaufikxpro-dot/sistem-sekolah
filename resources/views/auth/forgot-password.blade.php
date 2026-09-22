<x-guest-layout>
    <div class="bg-white dark:bg-gray-800 p-8 sm:p-10 rounded-2xl shadow-xl shadow-gray-200/60 dark:shadow-none border border-gray-100 dark:border-gray-700/80">
        <!-- Form Header -->
        <div class="mb-6">
            <h3 class="font-serif text-2xl font-bold text-navy-900 dark:text-white tracking-tight">
                Lupa Kata Sandi?
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-sm text-green-700 dark:text-green-300 flex items-center space-x-3">
                <svg class="w-5 h-5 shrink-0 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                    Alamat Email
                </label>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="contoh@sekolah.sch.id"
                        class="block w-full pl-11 pr-4 py-3 rounded-lg text-sm border-gray-200 dark:border-gray-700 dark:bg-gray-900/50 dark:text-white focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                    />
                </div>
                @if ($errors->has('email'))
                    <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 font-medium">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-navy-900 hover:bg-navy-700 active:bg-navy-900 text-white font-medium text-sm rounded-lg shadow-lg shadow-navy-900/15 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-700 transition-all duration-150 flex items-center justify-center space-x-2"
                >
                    <span>Kirim Tautan Reset Password</span>
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700/60 text-center">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-navy-900 dark:text-amber-100 hover:underline inline-flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Halaman Masuk</span>
            </a>
        </div>
    </div>
</x-guest-layout>

