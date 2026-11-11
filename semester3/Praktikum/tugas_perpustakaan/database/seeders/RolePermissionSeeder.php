<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Permission
        Permission::firstOrCreate(['name' => 'kelola data buku']);
        Permission::firstOrCreate(['name' => 'kelola pengguna']);

        // 2. Buat Role
        $roleAdmin   = Role::firstOrCreate(['name' => 'Admin']);
        $rolePetugas = Role::firstOrCreate(['name' => 'Petugas']);
        $roleSiswa   = Role::firstOrCreate(['name' => 'Siswa']);

        // Assign Permission ke Role
        $roleAdmin->givePermissionTo(Permission::all());
        $rolePetugas->givePermissionTo('kelola data buku');

        // 3. Buat Akun Default
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Administrator', 'password' => Hash::make('password')]
        );
        $admin->assignRole($roleAdmin);

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            ['name' => 'Petugas Perpustakaan', 'password' => Hash::make('password')]
        );
        $petugas->assignRole($rolePetugas);

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            ['name' => 'Siswa Contoh', 'password' => Hash::make('password')]
        );
        $siswa->assignRole($roleSiswa);
    }
}