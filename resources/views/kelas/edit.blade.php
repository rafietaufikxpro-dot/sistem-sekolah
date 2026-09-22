<x-app-layout>
    <x-slot name="header">
        Edit Data Kelas
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('kelas.update', $kelas->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('nama_kelas') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jurusan</label>
                <input type="text" name="jurusan" value="{{ old('jurusan', $kelas->jurusan) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('jurusan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Assign Wali Kelas (Guru)</label>
                <select name="wali_kelas_id" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}" {{ old('wali_kelas_id', $kelas->wali_kelas_id) == $g->id ? 'selected' : '' }}>
                            {{ $g->user->name ?? '-' }} (NIP: {{ $g->nip }})
                        </option>
                    @endforeach
                </select>
                @error('wali_kelas_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('kelas.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Perbarui Kelas</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
