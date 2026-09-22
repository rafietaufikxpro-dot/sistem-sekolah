<?php

namespace App\Policies;

use App\Models\Nilai;
use App\Models\User;

class NilaiPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru() || $user->isSiswa();
    }

    public function view(User $user, Nilai $nilai): bool
    {
        if ($user->isAdmin() || $user->isGuru()) {
            return true;
        }

        return $user->isSiswa() && $user->siswa?->id === $nilai->siswa_id;
    }

    public function create(User $user): bool
    {
        // Admin is explicitly blocked from modifying/creating grades
        return $user->isGuru();
    }

    public function update(User $user, Nilai $nilai): bool
    {
        // Admin is explicitly blocked from modifying grades
        // Guru can only edit their own entries
        return $user->isGuru() && $user->guru?->id === $nilai->guru_id;
    }

    public function delete(User $user, Nilai $nilai): bool
    {
        // Admin is explicitly blocked from deleting grades
        // Guru can only delete their own entries
        return $user->isGuru() && $user->guru?->id === $nilai->guru_id;
    }
}
