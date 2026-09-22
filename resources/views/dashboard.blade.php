<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    @if(Auth::user()->isAdmin())
        <!-- Admin Dashboard: Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Metrik Kecil -->
            <div class="col-span-1 md:col-span-1 lg:col-span-1">
                <x-metric-card label="Total Siswa" :value="$totalSiswa" sub="Seluruh jenjang">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </x-slot>
                </x-metric-card>
            </div>

            <div class="col-span-1 md:col-span-1 lg:col-span-1">
                <x-metric-card label="Total Guru" :value="$totalGuru" sub="Tenaga pendidik aktif">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </x-slot>
                </x-metric-card>
            </div>

            <!-- Bento Daftar Guru (Lebar) -->
            <div class="col-span-1 md:col-span-2 lg:col-span-2">
                <x-card class="h-full flex flex-col">
                    <h3 class="text-base font-semibold text-zinc-900 mb-4">Daftar Guru Terbaru</h3>
                    <div class="overflow-x-auto rounded-xl border border-zinc-100 flex-1">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-zinc-50/50 text-navy-700 font-medium text-xs">
                                <tr>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">NIP</th>
                                    <th class="px-4 py-3">Mapel</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @forelse($gurus as $g)
                                    <tr class="transition-colors">
                                        <td class="px-4 py-3 font-medium text-zinc-800">{{ $g->user->name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-navy-700">{{ $g->nip }}</td>
                                        <td class="px-4 py-3 text-navy-700">{{ $g->mapel }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-4 py-4 text-center text-navy-700 text-sm">Belum ada data guru.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>

            <!-- Bento Daftar Siswa (Lebar Penuh/2 Kolom jika di baris baru) -->
            <div class="col-span-1 md:col-span-2 lg:col-span-4">
                <x-card>
                    <h3 class="text-base font-semibold text-zinc-900 mb-4">Siswa Baru Terdaftar</h3>
                    <div class="overflow-x-auto rounded-xl border border-zinc-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-zinc-50/50 text-navy-700 font-medium text-xs">
                                <tr>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">NIS</th>
                                    <th class="px-4 py-3">Kelas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @forelse($siswas->take(5) as $s)
                                    <tr class="transition-colors">
                                        <td class="px-4 py-3 font-medium text-zinc-800">{{ $s->user->name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-navy-700">{{ $s->nis }}</td>
                                        <td class="px-4 py-3 text-navy-700">{{ $s->kelas->nama_kelas ?? 'Belum ada' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-4 py-4 text-center text-navy-700 text-sm">Belum ada data siswa.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
        </div>
    @elseif(Auth::user()->isGuru())
        <!-- Guru Dashboard: Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="col-span-1">
                <x-metric-card label="Kelas Perwalian" :value="$kelasWali->nama_kelas ?? '-'" :sub="$kelasWali ? 'Jurusan: '.$kelasWali->jurusan : 'Belum ditugaskan'">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9"></path></svg>
                    </x-slot>
                </x-metric-card>
            </div>

            <div class="col-span-1">
                <x-metric-card label="Total Siswa Wali" :value="$totalSiswaWali" sub="Siswa di kelas Anda">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </x-slot>
                </x-metric-card>
            </div>
            
            <div class="col-span-1 lg:col-span-3">
                <x-card>
                    <h3 class="text-base font-semibold text-zinc-900 mb-4">Pengajuan Menunggu Persetujuan</h3>
                    <div class="overflow-x-auto rounded-xl border border-zinc-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-zinc-50/50 text-navy-700 font-medium text-xs">
                                <tr>
                                    <th class="px-4 py-3">Siswa</th>
                                    <th class="px-4 py-3">Jenis Pengajuan</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @forelse($pengajuanMasuk as $p)
                                    <tr class="transition-colors">
                                        <td class="px-4 py-3 font-medium text-zinc-800">{{ $p->siswa->user->name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-navy-700">{{ $p->jenis_pengajuan }}</td>
                                        <td class="px-4 py-3 text-navy-700">{{ $p->tanggal_pengajuan->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <x-button variant="primary" href="{{ route('pengajuan.review', $p->id) }}" class="text-xs py-1.5 px-3">
                                                Proses
                                            </x-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-4 text-center text-navy-700 text-sm">Tidak ada pengajuan yang menunggu.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
        </div>
    @else
        <!-- Siswa Dashboard: Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="col-span-1">
                <x-metric-card label="Total Nilai" :value="$nilaiCount" sub="Data nilai terdaftar">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </x-slot>
                </x-metric-card>
            </div>

            <div class="col-span-1">
                <x-metric-card label="Pengajuan" :value="$pengajuanCount" sub="Surat & dispensasi">
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </x-slot>
                </x-metric-card>
            </div>

            <div class="col-span-1 lg:col-span-3">
                <x-card>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-zinc-900">Riwayat Pengajuan</h3>
                        <x-button variant="primary" href="{{ route('pengajuan.create') }}" class="text-xs py-1.5 px-3">
                            + Buat
                        </x-button>
                    </div>
                    <div class="overflow-x-auto rounded-xl border border-zinc-100">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-zinc-50/50 text-navy-700 font-medium text-xs">
                                <tr>
                                    <th class="px-4 py-3">Jenis Pengajuan</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-right">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @forelse($pengajuanTerbaru as $p)
                                    <tr class="transition-colors">
                                        <td class="px-4 py-3 font-medium text-zinc-800">{{ $p->jenis_pengajuan }}</td>
                                        <td class="px-4 py-3 text-navy-700">{{ $p->tanggal_pengajuan->format('d M Y') }}</td>
                                        <td class="px-4 py-3"><x-badge :status="$p->status" /></td>
                                        <td class="px-4 py-3 text-right">
                                            <x-button variant="ghost" href="{{ route('pengajuan.show', $p->id) }}" class="text-xs py-1.5 px-3">
                                                Lihat
                                            </x-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-4 text-center text-navy-700 text-sm">Belum ada pengajuan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
        </div>
    @endif
</x-app-layout>
