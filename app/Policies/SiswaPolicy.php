<?php

namespace App\Policies;

use App\Models\Siswa;
use App\Models\User;

class SiswaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function view(User $user, Siswa $siswa): bool
    {
        if ($user->isAdmin() || $user->isGuru()) {
            return true;
        }

        return $user->isSiswa() && $user->siswa?->id === $siswa->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function update(User $user, Siswa $siswa): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isGuru()) {
            return $user->guru?->kelas?->id === $siswa->kelas_id;
        }

        return false;
    }

    public function delete(User $user, Siswa $siswa): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isGuru()) {
            return $user->guru?->kelas?->id === $siswa->kelas_id;
        }

        return false;
    }
}
