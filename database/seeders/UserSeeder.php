<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan roles sudah ada
        $roles = ['guru', 'orangtua', 'guest'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Buat user guru
        $guru = User::firstOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru User',
                'username' => 'guru123',
                'password' => Hash::make('password'),
            ]
        );
        $guru->assignRole('guru');

        // Buat user orangtua
        $orangtua = User::firstOrCreate(
            ['email' => 'orangtua@example.com'],
            [
                'name' => 'Orangtua User',
                'username' => 'ortu123',
                'password' => Hash::make('password'),
            ]
        );
        $orangtua->assignRole('orangtua');

        // Buat user guest
        $guest = User::firstOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'Guest User',
                'username' => 'guest123',
                'password' => Hash::make('password'),
            ]
        );
        $guest->assignRole('guest');
    }
}
