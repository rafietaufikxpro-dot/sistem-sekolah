<?php

namespace App\Policies;

use App\Models\Pengajuan;
use App\Models\User;

class PengajuanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru() || $user->isSiswa();
    }

    public function view(User $user, Pengajuan $pengajuan): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isGuru()) {
            $kelasId = $user->guru?->kelas?->id;

            return $kelasId !== null && $pengajuan->siswa?->kelas_id === $kelasId;
        }

        return $user->isSiswa() && $user->siswa?->id === $pengajuan->siswa_id;
    }

    public function create(User $user): bool
    {
        return $user->isSiswa();
    }

    public function review(User $user, Pengajuan $pengajuan): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isGuru()) {
            $kelasId = $user->guru?->kelas?->id;

            return $kelasId !== null && $pengajuan->siswa?->kelas_id === $kelasId;
        }

        return false;
    }

    public function update(User $user, Pengajuan $pengajuan): bool
    {
        if (! $user->isAdmin()) {
            return false;
        }

        return $pengajuan->status === 'menunggu';
    }

    public function delete(User $user, Pengajuan $pengajuan): bool
    {
        return $user->isAdmin();
    }
}
