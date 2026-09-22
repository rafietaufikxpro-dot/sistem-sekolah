<x-app-layout>
    <x-slot name="header">
        Edit Data Guru
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('guru.update', $guru->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Nama Lengkap & Gelar</label>
                <input type="text" name="name" value="{{ old('name', $guru->user->name ?? '') }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $guru->user->email ?? '') }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    @error('nip') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Mata Pelajaran</label>
                    <input type="text" name="mapel" value="{{ old('mapel', $guru->mapel) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    @error('mapel') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('guru.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Perbarui Data Guru</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
