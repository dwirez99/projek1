<?php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Orangtua;
use App\Models\Pesertadidik;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PesertadidikSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = ['A', 'B'];
        $namaDepanOrtu = ['Budi', 'Siti', 'Agus', 'Dewi', 'Joko', 'Sri', 'Andi', 'Rina', 'Eko', 'Fitri', 'Tono', 'Yuni', 'Dedi', 'Lina', 'Rudi', 'Maya', 'Hendra', 'Nina'];
        $namaBelakangOrtu = ['Santoso', 'Wati', 'Saputra', 'Lestari', 'Pratama', 'Utami', 'Wijaya', 'Sari', 'Putra', 'Rahmawati', 'Susilo', 'Handayani', 'Permana', 'Indah', 'Setiawan', 'Anggraini', 'Kusuma', 'Purnama'];
        $namaDepanAnak = ['Adit', 'Putri', 'Rafi', 'Nadia', 'Dimas', 'Alya', 'Fajar', 'Citra', 'Rizki', 'Intan', 'Bagas', 'Vina', 'Yoga', 'Dina', 'Galih', 'Mega', 'Ilham', 'Salsa'];
        $namaBelakangAnak = ['Pratama', 'Lestari', 'Saputra', 'Utami', 'Wijaya', 'Sari', 'Putra', 'Rahmawati', 'Susilo', 'Handayani', 'Permana', 'Indah', 'Setiawan', 'Anggraini', 'Kusuma', 'Purnama', 'Santoso', 'Wati'];
        $genderList = ['L', 'P'];

        $counter = 1;
        foreach ($kelasList as $kelas) {
            for ($i = 0; $i < 9; $i++) {
                // Nama orangtua random
                $namaOrtu = $namaDepanOrtu[$i] . ' ' . $namaBelakangOrtu[$i];
                $nickname = Str::slug($namaDepanOrtu[$i]);
                $notelp = '0812' . rand(10000000, 99999999);
                $alamat = "Jl. Mawar No. " . rand(1, 99);
                $email = Str::slug($namaOrtu) . "@mail.com";
                $username = Str::slug($nickname . $counter);

                // Buat user
                $user = User::create([
                    'name' => $namaOrtu,
                    'username' => $username,
                    'email' => $email,
                    'notelp' => $notelp,
                    'alamat' => $alamat,
                    'password' => Hash::make('password'),
                ]);
                $user->assignRole('orangtua');

                // Buat data orangtua
                $orangtua = Orangtua::create([
                    'user_id' => $user->id,
                    'namaortu' => $namaOrtu,
                    'nickname' => $nickname,
                    'emailortu' => $email,
                    'notelportu' => $notelp,
                    'alamat' => $alamat,
                ]);

                // Nama anak random
                $namaAnak = $namaDepanAnak[$i] . ' ' . $namaBelakangAnak[$i];
                $nis = 1000000000 + $counter;
                $tglLahir = now()->subYears(rand(5, 7))->subDays(rand(0, 365))->format('Y-m-d');
                $jk = $genderList[$i % 2];
                $tinggi = rand(100, 130);
                $berat = rand(18, 35);
                $foto = "https://loremflickr.com/320/240/child?lock={$nis}";

                Pesertadidik::create([
                    'nis' => $nis,
                    'idortu' => $orangtua->id,
                    'namapd' => $namaAnak,
                    'tanggallahir' => $tglLahir,
                    'jeniskelamin' => $jk,
                    'kelas' => $kelas,
                    'fase' => 'A',
                    'tinggibadan' => $tinggi,
                    'beratbadan' => $berat,
                    'foto' => $foto,
                ]);

                $counter++;
            }
        }
    }
}
