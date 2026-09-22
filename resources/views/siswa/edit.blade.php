<x-app-layout>
    <x-slot name="header">
        Edit Data Siswa
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('siswa.update', $siswa->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $siswa->user->name ?? '') }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $siswa->user->email ?? '') }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    @error('nis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Kelas</label>
                    <select name="kelas_id" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }} ({{ $k->jurusan }})</option>
                        @endforeach
                    </select>
                    @error('kelas_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">{{ old('alamat', $siswa->alamat) }}</textarea>
                @error('alamat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Foto Profile (Kosongkan jika tidak diganti)</label>
                @if($siswa->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="w-16 h-16 rounded-full object-cover">
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('foto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('siswa.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Perbarui Data Siswa</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
