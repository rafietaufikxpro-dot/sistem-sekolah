<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Sekolah') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Dot grid pattern for left panel */
            .dot-grid {
                background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
                background-size: 24px 24px;
            }
            /* Fade-in animation */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(16px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up {
                animation: fadeInUp 0.45s ease both;
            }
            .animate-fade-in-up-delay {
                animation: fadeInUp 0.45s ease 0.1s both;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-paper min-h-screen selection:bg-navy-700 selection:text-white">
        <div class="min-h-screen flex flex-col lg:flex-row">

            {{-- ===== LEFT BRANDING PANEL ===== --}}
            <div class="lg:w-5/12 bg-navy-900 text-white flex flex-col justify-between relative overflow-hidden">

                {{-- Dot grid texture --}}
                <div class="absolute inset-0 dot-grid pointer-events-none"></div>

                {{-- Glow blobs --}}
                <div class="absolute -top-32 -left-32 w-[28rem] h-[28rem] bg-navy-700/50 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-32 -right-16 w-[24rem] h-[24rem] bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-navy-600/20 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 p-8 lg:p-12">
                    {{-- Brand --}}
                    <div class="flex items-center space-x-3 mb-10 lg:mb-14">
                        <div class="w-12 h-12 rounded-2xl bg-navy-700 border border-navy-600/60 flex items-center justify-center shadow-lg shadow-black/30 flex-shrink-0">
                            <img src="{{ asset('favicon.svg') }}" alt="Logo" class="w-8 h-8">
                        </div>
                        <div>
                            <span class="font-serif font-bold text-xl tracking-tight text-white block leading-tight">Sistem Sekolah</span>
                            <span class="text-[11px] text-navy-100/60 font-medium tracking-widest uppercase">Portal Akademik Terpadu</span>
                        </div>
                    </div>

                    {{-- Headline --}}
                    <div class="space-y-4 mb-10 lg:mb-12">
                        <h2 class="font-serif text-2xl lg:text-[2rem] font-semibold leading-snug text-white">
                            Kelola Pembelajaran &amp; Administrasi Sekolah<br>
                            <span class="text-navy-100/70">dalam Satu Tempat</span>
                        </h2>
                        <p class="text-sm text-gray-300 leading-relaxed max-w-sm">
                            Akses transparan untuk Siswa, Guru, dan Administrator. Cek nilai, ajukan surat, dan pantau informasi sekolah secara real-time.
                        </p>
                    </div>

                    {{-- Feature list --}}
                    <div class="hidden sm:flex flex-col space-y-4">
                        @foreach([
                            ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Transkrip & Rekap Nilai', 'desc' => 'Pantau nilai tugas, UTS, dan UAS per semester.'],
                            ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title' => 'Pengajuan Surat Online', 'desc' => 'Ajukan izin dan surat keterangan sekolah secara praktis.'],
                            ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Keamanan & Privasi Data', 'desc' => 'Otentikasi role terverifikasi untuk setiap pengguna.'],
                        ] as $f)
                            <div class="flex items-start space-x-3">
                                <div class="mt-0.5 p-1.5 bg-navy-700/80 rounded-lg text-navy-100 border border-navy-600/40 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white leading-tight">{{ $f['title'] }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $f['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Footer panel --}}
                <div class="relative z-10 px-8 lg:px-12 pb-8 lg:pb-10 pt-6 border-t border-navy-700/50 flex items-center justify-between text-xs text-gray-500">
                    <span>&copy; {{ date('Y') }} Sistem Sekolah</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-navy-800 text-navy-100/70 border border-navy-700/60">
                        v1.0.0
                    </span>
                </div>
            </div>

            {{-- ===== RIGHT FORM PANEL ===== --}}
            <div class="lg:w-7/12 flex-1 flex flex-col justify-center items-center p-6 sm:p-10 lg:p-16 bg-paper">

                {{-- Mobile logo header (only visible <lg) --}}
                <div class="lg:hidden flex items-center space-x-3 mb-8 self-start">
                    <div class="w-9 h-9 rounded-xl bg-navy-900 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('favicon.svg') }}" alt="Logo" class="w-6 h-6">
                    </div>
                    <div>
                        <span class="font-serif font-semibold text-base text-navy-900 block leading-tight">Sistem Sekolah</span>
                        <span class="text-[10px] text-navy-700/60 font-medium tracking-widest uppercase">Portal Akademik</span>
                    </div>
                </div>

                <div class="w-full max-w-md animate-fade-in-up">

                    {{-- Flash alerts --}}
                    @if (session('success'))
                        <div
                            x-data="{ show: true }"
                            x-show="show"
                            x-init="setTimeout(() => show = false, 4000)"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm font-medium flex items-center justify-between gap-3"
                        >
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="text-green-600 hover:text-green-800 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            x-data="{ show: true }"
                            x-show="show"
                            x-init="setTimeout(() => show = false, 5000)"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium flex items-center justify-between gap-3"
                        >
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button @click="show = false" class="text-red-600 hover:text-red-800 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    {{-- Form card --}}
                    <div class="bg-white rounded-3xl shadow-2xl shadow-navy-900/10 border border-gray-100 p-8 sm:p-10 animate-fade-in-up-delay">
                        {{ $slot }}
                    </div>

                </div>
            </div>

        </div>
    </body>
</html>
