<x-app-layout>
    <x-slot name="header">
        Input Nilai Akademik
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('nilai.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Pilih Siswa</label>
                <select name="siswa_id" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->user->name ?? '-' }} (NIS: {{ $s->nis }} - {{ $s->kelas->nama_kelas ?? 'Tanpa Kelas' }})
                        </option>
                    @endforeach
                </select>
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
