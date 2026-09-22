<x-app-layout>
    <x-slot name="header">
        Edit / Moderasi Pengajuan
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('pengajuan.update', $pengajuan->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="p-3 bg-navy-100  rounded-lg text-sm mb-4">
                <span class="text-xs font-semibold uppercase text-navy-700 block">Siswa Pemohon</span>
                <span class="font-medium text-navy-900 ">{{ $pengajuan->siswa->user->name ?? '-' }}</span>
                <span class="text-xs text-navy-700 block">NIS: {{ $pengajuan->siswa->nis }}</span>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jenis Pengajuan</label>
                <input type="text" name="jenis_pengajuan" value="{{ old('jenis_pengajuan', $pengajuan->jenis_pengajuan) }}" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('jenis_pengajuan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Keterangan Siswa</label>
                <textarea name="keterangan" rows="3" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">{{ old('keterangan', $pengajuan->keterangan) }}</textarea>
                @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Status Pengajuan</label>
                <select name="status" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                    <option value="menunggu" {{ old('status', $pengajuan->status) === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ old('status', $pengajuan->status) === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ old('status', $pengajuan->status) === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Catatan Guru / Admin</label>
                <textarea name="catatan_guru" rows="2" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">{{ old('catatan_guru', $pengajuan->catatan_guru) }}</textarea>
                @error('catatan_guru') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('pengajuan.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Perbarui Moderasi</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
