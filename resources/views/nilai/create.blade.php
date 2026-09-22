<x-app-layout>
    <x-slot name="header">
        Input Nilai Akademik
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('nilai.store') }}" class="space-y-4">
            @csrf

            <div
                x-data="{
                    open: false,
                    query: @js(old('siswa_id') ? optional($siswas->firstWhere('id', (int) old('siswa_id')))->user->name ?? '' : ''),
                    siswaId: @js(old('siswa_id', '')),
                    siswas: @js($siswas->map(fn ($s) => [
                        'id' => $s->id,
                        'label' => ($s->user->name ?? '-') . ' (NIS: ' . $s->nis . ' - ' . ($s->kelas->nama_kelas ?? 'Tanpa Kelas') . ')',
                    ])),
                    get filtered() {
                        if (!this.query) return this.siswas;
                        const q = this.query.toLowerCase();
                        return this.siswas.filter(s => s.label.toLowerCase().includes(q));
                    },
                    select(s) {
                        this.siswaId = s.id;
                        this.query = s.label;
                        this.open = false;
                    },
                }"
                class="relative"
                @click.outside="open = false"
            >
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Pilih Siswa</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-navy-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"></path></svg>
                    <input
                        type="text"
                        x-model="query"
                        @focus="open = true"
                        @input="open = true; siswaId = ''"
                        @keydown.escape="open = false"
                        autocomplete="off"
                        placeholder="Cari nama atau NIS siswa..."
                        class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)] pl-9"
                    >
                    <input type="hidden" name="siswa_id" :value="siswaId" required>
                </div>

                <div
                    x-show="open"
                    x-cloak
                    class="absolute z-20 mt-1 w-full max-h-60 overflow-auto rounded-lg border border-[var(--border)] bg-white shadow-lg"
                >
                    <template x-if="filtered.length === 0">
                        <p class="px-3 py-2 text-sm text-navy-400">Siswa tidak ditemukan</p>
                    </template>
                    <template x-for="s in filtered" :key="s.id">
                        <button
                            type="button"
                            @click="select(s)"
                            class="block w-full text-left px-3 py-2 text-sm text-[var(--ink-900)] hover:bg-navy-100 transition-colors"
                            x-text="s.label"
                        ></button>
                    </template>
                </div>

                @error('siswa_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Tahun Ajaran (contoh: 2025/2026)</label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', '2025/2026') }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    @error('tahun_ajaran') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Semester</label>
                    <select name="semester" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}" {{ old('semester', 1) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                    @error('semester') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jenis Nilai</label>
                    <select name="jenis_nilai" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                        <option value="tugas" {{ old('jenis_nilai') === 'tugas' ? 'selected' : '' }}>Tugas</option>
                        <option value="uts" {{ old('jenis_nilai') === 'uts' ? 'selected' : '' }}>UTS</option>
                        <option value="uas" {{ old('jenis_nilai') === 'uas' ? 'selected' : '' }}>UAS</option>
                    </select>
                    @error('jenis_nilai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Nilai Angka (0 - 100)</label>
                    <input type="number" step="0.01" min="0" max="100" name="nilai" value="{{ old('nilai') }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    @error('nilai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Keterangan / Catatan (Opsional)</label>
                <textarea name="keterangan" rows="2" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">{{ old('keterangan') }}</textarea>
                @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('nilai.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Simpan Nilai</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
