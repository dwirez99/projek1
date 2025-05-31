<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $GuruRole = Role::create(['name' => 'guru']);
        $OrangtuaRole = Role::create(['name' => 'orangtua']);
        $GuestRole = Role::create(['name' => 'Guest']);

        $TambahPesertaDidikPermission = Permission::create(['name' => 'tambah siswa']);
        $EditPesertaDidikPermission = Permission::create(['name' => 'edit post']);
        $HapusPesertaDidikPermission = Permission::create(['name' => 'delete post']);
        $TambahPostinganPermission = Permission::create(['name' => 'tambah postingan']);
        $HapusPostinganPermission = Permission::create(['name' => 'delete Postingan']);
        $EditPostinganPermission = Permission::create(['name' => 'edit Postingan']);
        $ValidasiDaftarPesertaDidikPermission = Permission::create(['name' => 'Validasi daftar Peserta Didik']);


        $DaftarPesertaDidikPermission = Permission::create(['name' => 'daftar peserta didik']);
        $RegistrasiOrangtuaPermission = Permission::create(['name' => 'registrasi orangtua']);
        $ProfilPesertaDidikPermission = Permission::create(['name' => 'profil peserta didik']);



        $GuruRole->givePermissionTo($TambahPesertaDidikPermission);
        $GuruRole->givePermissionTo($EditPesertaDidikPermission);
        $GuruRole->givePermissionTo($HapusPesertaDidikPermission);
        $GuruRole->givePermissionTo($TambahPesertaDidikPermission);
        $GuruRole->givePermissionTo($TambahPostinganPermission);
        $GuruRole->givePermissionTo($EditPostinganPermission);
        $GuruRole->givePermissionTo($HapusPostinganPermission);
        $GuruRole->givePermissionTo($ValidasiDaftarPesertaDidikPermission);


        $OrangtuaRole->givePermissionTo($DaftarPesertaDidikPermission);
        $OrangtuaRole->givePermissionTo($ProfilPesertaDidikPermission);


        $GuestRole->givePermissionTo($RegistrasiOrangtuaPermission);





    }
}
