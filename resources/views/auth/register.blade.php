<x-guest-layout>
    
        <!-- Form Header -->
        <div class="mb-8">
            <h3 class="font-serif text-2xl font-bold text-navy-900 tracking-tight">
                Registrasi Mandiri Siswa
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Lengkapi formulir di bawah ini untuk membuat akun siswa baru.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name & NIS (2 Column layout on sm screen) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Lengkap -->
                <div>
                    <div class="h-5 flex items-center mb-1.5">
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">
                            Nama Lengkap
                        </label>
                    </div>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name" 
                            placeholder="Nama Siswa"
                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                        />
                    </div>
                    @if ($errors->has('name'))
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>

                <!-- NIS -->
                <div>
                    <div class="h-5 flex items-center mb-1.5">
                        <label for="nis" class="block text-xs font-semibold uppercase tracking-wider text-gray-700 truncate">
                            NIS (Nomor Induk Siswa)
                        </label>
                    </div>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                            </svg>
                        </div>
                        <input 
                            id="nis" 
                            type="text" 
                            name="nis" 
                            value="{{ old('nis') }}" 
                            required 
                            placeholder="Contoh: 1004"
                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                        />
                    </div>
                    @if ($errors->has('nis'))
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            {{ $errors->first('nis') }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Email & Jenis Kelamin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Email Address -->
                <div>
                    <div class="h-5 flex items-center mb-1.5">
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">
                            Alamat Email
                        </label>
                    </div>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="username" 
                            placeholder="siswa@sekolah.sch.id"
                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                        />
                    </div>
                    @if ($errors->has('email'))
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <div class="h-5 flex items-center mb-1.5">
                        <label for="jenis_kelamin" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">
                            Jenis Kelamin
                        </label>
                    </div>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <select 
                            id="jenis_kelamin" 
                            name="jenis_kelamin" 
                            required 
                            class="block w-full pl-10 pr-8 py-2.5 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                        >
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    @if ($errors->has('jenis_kelamin'))
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            {{ $errors->first('jenis_kelamin') }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Alamat Lengkap -->
            <div>
                <div class="h-5 flex items-center mb-1.5">
                    <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">
                        Alamat Lengkap
                    </label>
                </div>
                <div class="relative rounded-lg shadow-sm">
                    <div class="absolute top-3 left-0 pl-3.5 flex items-start pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        rows="2" 
                        required 
                        placeholder="Alamat domisili lengkap..."
                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                    >{{ old('alamat') }}</textarea>
                </div>
                @if ($errors->has('alamat'))
                    <p class="mt-1 text-xs text-red-600 font-medium">
                        {{ $errors->first('alamat') }}
                    </p>
                @endif
            </div>

            <!-- Password & Confirm Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ showPassword: false }">
                <!-- Password -->
                <div>
                    <div class="h-5 flex items-center mb-1.5">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input 
                            id="password" 
                            :type="showPassword ? 'text' : 'password'" 
                            name="password" 
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••"
                            class="block w-full pl-10 pr-10 py-2.5 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                        />
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                        >
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.022 10.022 0 013.122-.443c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.072 3.864m-4.577 2.127A3 3 0 019.879 9.879M6.343 6.343l11.314 11.314"/>
                            </svg>
                        </button>
                    </div>
                    @if ($errors->has('password'))
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div>
                    <div class="h-5 flex items-center mb-1.5">
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-700">
                            Konfirmasi Kata Sandi
                        </label>
                    </div>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input 
                            id="password_confirmation" 
                            :type="showPassword ? 'text' : 'password'" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••"
                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg text-sm border-gray-200 focus:border-navy-700 focus:ring-2 focus:ring-navy-700/20 transition-colors duration-150"
                        />
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <p class="mt-1 text-xs text-red-600 font-medium">
                            {{ $errors->first('password_confirmation') }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-navy-900 hover:bg-navy-700 active:bg-navy-900 text-white font-medium text-sm rounded-lg shadow-lg shadow-navy-900/15 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy-700 transition-all duration-150 flex items-center justify-center space-x-2"
                >
                    <span>Daftar Akun Siswa</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Footer Link -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-semibold text-navy-900 hover:underline">
                    Masuk ke Portal &rarr;
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>

