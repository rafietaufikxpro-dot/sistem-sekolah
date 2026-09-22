<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['id' => 1], ['name_role' => 'siswa']);
        Role::firstOrCreate(['id' => 2], ['name_role' => 'guru']);
        Role::firstOrCreate(['id' => 3], ['name_role' => 'admin']);
    }
}
