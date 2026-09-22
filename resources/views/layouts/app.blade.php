<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Sekolah') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Google Fonts CDN: Inter & Source Serif 4 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,500;8..60,600&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-[var(--ink-900)] bg-[var(--paper)]">
    <div x-data="{ sidebarOpen: false, sidebarCollapsed: false }" class="min-h-screen flex flex-col min-[820px]:flex-row">
        
        <!-- Mobile Header (Visible <820px) -->
        <header class="min-[820px]:hidden bg-navy-900 text-white px-4 py-3 flex items-center justify-between sticky top-0 z-50">
            <div class="flex items-center space-x-3">
                <span class="font-serif font-semibold text-lg">Sistem Sekolah</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-300 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </header>

        <!-- Sidebar Navigation (230px on desktop) -->
        <aside
            :class="sidebarOpen ? 'block' : 'hidden'"
            class="min-[820px]:block flex-shrink-0 min-h-screen z-40 min-[820px]:sticky min-[820px]:top-0 flex flex-col justify-between bg-navy-900 text-white transition-all duration-300"
            :style="sidebarCollapsed ? 'width: 64px' : 'width: 230px'"
            style="width: 230px"
        >
            <div class="overflow-hidden">
                <!-- Brand Title + Collapse Button -->
                <div class="hidden min-[820px]:flex items-center justify-between px-4 py-5 border-b border-navy-700">
                    <h1 x-show="!sidebarCollapsed" class="font-serif font-semibold text-xl tracking-tight text-white whitespace-nowrap">Sistem Sekolah</h1>
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-1.5 text-gray-400 hover:text-white transition-colors rounded-lg hover:bg-navy-700/50 flex-shrink-0" title="Toggle Sidebar">
                        <svg class="w-5 h-5 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-4 px-2 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-navy-700 text-white' : 'text-gray-300 hover:bg-navy-700/50 hover:text-white' }}" :title="sidebarCollapsed ? 'Dashboard' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 00-1 1m-6 0h6"></path></svg>
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
                    </a>

                    @if(Auth::user()->isAdmin() || Auth::user()->isGuru())
                        <a href="{{ route('siswa.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('siswa.*') ? 'bg-navy-700 text-white' : 'text-gray-300 hover:bg-navy-700/50 hover:text-white' }}" :title="sidebarCollapsed ? 'Data Siswa' : ''">
                            <svg class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data Siswa</span>
                        </a>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('guru.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('guru.*') ? 'bg-navy-700 text-white' : 'text-gray-300 hover:bg-navy-700/50 hover:text-white' }}" :title="sidebarCollapsed ? 'Manajemen Guru' : ''">
                            <svg class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Manajemen Guru</span>
                        </a>
                    @endif

                    @if(Auth::user()->isAdmin() || Auth::user()->isGuru())
                        <a href="{{ route('kelas.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('kelas.*') ? 'bg-navy-700 text-white' : 'text-gray-300 hover:bg-navy-700/50 hover:text-white' }}" :title="sidebarCollapsed ? 'Data Kelas' : ''">
                            <svg class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9"></path></svg>
                            <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data Kelas</span>
                        </a>
                    @endif

                    <a href="{{ route('nilai.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('nilai.*') ? 'bg-navy-700 text-white' : 'text-gray-300 hover:bg-navy-700/50 hover:text-white' }}" :title="sidebarCollapsed ? 'Nilai Akademik' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Nilai Akademik</span>
                    </a>

                    <a href="{{ route('pengajuan.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pengajuan.*') ? 'bg-navy-700 text-white' : 'text-gray-300 hover:bg-navy-700/50 hover:text-white' }}" :title="sidebarCollapsed ? 'Pengajuan' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Pengajuan Administrasi</span>
                    </a>
                </nav>
            </div>

            <!-- User Info & Logout -->
            <div class="p-3 border-t border-navy-700">
                <div class="flex items-center" :class="sidebarCollapsed ? 'justify-center' : 'justify-between'">
                    <div x-show="!sidebarCollapsed" class="truncate mr-2">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role->name_role ?? 'User' }}</p>
                    </div>
                    <span x-data="{ open: false }" class="inline-flex">
                        <button type="button" @click="open = true" class="p-1.5 text-gray-400 hover:text-red-400 transition-colors" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>

                        {{-- Modal Konfirmasi Logout --}}
                        <div
                            x-show="open"
                            x-transition:enter="ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 z-50 flex items-center justify-center px-4"
                            style="display: none;"
                        >
                            <div class="absolute inset-0 bg-navy-900/50" @click="open = false"></div>
                            <div
                                x-show="open"
                                x-transition:enter="ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 z-10"
                            >
                                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-navy-100 mx-auto mb-4">
                                    <svg class="w-6 h-6 text-navy-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <h3 class="text-base font-semibold text-navy-900 text-center mb-1">Keluar dari Portal?</h3>
                                <p class="text-sm text-navy-700 text-center mb-6">Sesi Anda akan diakhiri. Yakin ingin keluar?</p>
                                <div class="flex gap-3">
                                    <button type="button" @click="open = false" class="flex-1 px-4 py-2 text-sm font-medium rounded-lg border border-navy-700 text-navy-700 hover:bg-navy-100 transition-colors">
                                        Tidak
                                    </button>
                                    <button type="button" @click="open = false; document.getElementById('logout-form').submit()" class="flex-1 px-4 py-2 text-sm font-medium rounded-lg bg-navy-900 text-white hover:bg-navy-700 transition-colors">
                                        Ya, Keluar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar Sticky -->
            <header class="sticky top-0 z-30 bg-[var(--card)] border-b border-[var(--border)] px-6 py-4 flex items-center justify-between">
                <div>
                    @if (isset($header))
                        <h2 class="font-serif font-semibold text-xl text-[var(--ink-900)] leading-tight">
                            {{ $header }}
                        </h2>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-ink-500 font-medium capitalize">
                        Role: <span class="text-navy-700 font-semibold">{{ Auth::user()->role->name_role ?? 'User' }}</span>
                    </span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 flex-1">
                <!-- Session Alert -->
                @if (session('success'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-init="setTimeout(() => show = false, 4000)"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm font-medium flex items-center justify-between gap-3"
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
                        class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium flex items-center justify-between gap-3"
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

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
