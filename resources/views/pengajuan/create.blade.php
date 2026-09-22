<x-app-layout>
    <x-slot name="header">
        Buat Pengajuan Administrasi
    </x-slot>

    <x-card class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Jenis Pengajuan</label>
                <input type="text" name="jenis_pengajuan" value="{{ old('jenis_pengajuan') }}" placeholder="Contoh: Surat Keterangan Siswa Aktif, Izin Dispensasi Lomba" required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('jenis_pengajuan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Keterangan / Alasan Pengajuan</label>
                <textarea name="keterangan" rows="4" placeholder="Jelaskan secara singkat keperluan pengajuan Anda..." required class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">{{ old('keterangan') }}</textarea>
                @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-navy-700 mb-1">Upload File Lampiran (Opsional - PDF/JPG/PNG/DOC max 5MB)</label>
                <input type="file" name="file_lampiran" class="w-full text-sm rounded-lg border-[var(--border)] bg-[var(--paper)] text-[var(--ink-900)]">
                @error('file_lampiran') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-button variant="ghost" href="{{ route('pengajuan.index') }}">Batal</x-button>
                <x-button variant="primary" type="submit">Kirim Pengajuan</x-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
