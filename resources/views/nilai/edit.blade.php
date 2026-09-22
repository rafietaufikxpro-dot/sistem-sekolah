<x-app-layout>
    <x-slot name="header">
        Edit Nilai Akademik
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('nilai.update', $nilai->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="p-3 bg-navy-100  rounded-lg text-sm mb-4">
                <span class="text-xs font-semibold uppercase text-navy-700 block">Siswa Target</span>
                <span class="font-medium text-navy-900 ">{{ $nilai->siswa->user->name ?? '-' }}</span>
                <span class="text-xs text-navy-700 block">NIS: {{ $nilai->siswa->nis }} | Kelas: {{ $nilai->siswa->kelas->nama_kelas ?? '-' }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $nilai->tahun_ajaran) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    @error('tahun_ajaran') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Semester</label>
                    <select name="semester" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}" {{ old('semester', $nilai->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                    @error('semester') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jenis Nilai</label>
                    <select name="jenis_nilai" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                        <option value="tugas" {{ old('jenis_nilai', $nilai->jenis_nilai) === 'tugas' ? 'selected' : '' }}>Tugas</option>
                        <option value="uts" {{ old('jenis_nilai', $nilai->jenis_nilai) === 'uts' ? 'selected' : '' }}>UTS</option>
                        <option value="uas" {{ old('jenis_nilai', $nilai->jenis_nilai) === 'uas' ? 'selected' : '' }}>UAS</option>
                    </select>
                    @error('jenis_nilai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Nilai Angka (0 - 100)</label>
                    <input type="number" step="0.01" min="0" max="100" name="nilai" value="{{ old('nilai', $nilai->nilai) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    @error('nilai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Keterangan / Catatan</label>
                <textarea name="keterangan" rows="2" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">{{ old('keterangan', $nilai->keterangan) }}</textarea>
                @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('nilai.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Perbarui Nilai</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
