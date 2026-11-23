<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'guru', 'siswa'] as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        $akun = [
            ['Admin Dummy', 'admin@test.com', 'admin'],
            ['Guru Dummy',  'guru@test.com',  'guru'],
            ['Siswa Dummy', 'siswa@test.com', 'siswa'],
        ];

        foreach ($akun as [$name, $email, $role]) {
            $u = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => Hash::make('password')]
            );
            $u->assignRole($role);
        }
    }
}