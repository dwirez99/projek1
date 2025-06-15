<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Orangtua;
use App\Models\Pesertadidik;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PesertaDidikDanOrangtuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasList = ['A', 'B'];
        $genderList = ['L', 'P'];

        $totalPerKelas = 9;
        $tahunAjar = '2024/2025';

        $counter = 1;
        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= $totalPerKelas; $i++) {
                // Data orangtua
                $namaOrtu = "Orangtua {$kelas}{$i}";
                $nickname = "ortu_{$kelas}{$i}";
                $notelp = '08123' . str_pad($counter, 6, '0', STR_PAD_LEFT);
                $alamat = "Jl. Contoh {$kelas}{$i}";
                $email = "ortu{$kelas}{$i}@mail.com";
                $username = Str::slug($nickname);

                // Buat user
                $user = User::create([
                    'name' => $namaOrtu,
                    'username' => $username,
                    'email' => $email,
                    'notelp' => $notelp,
                    'alamat' => $alamat,
                    'password' => Hash::make('password'), // default password
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

                // Data peserta didik
                $namaAnak = "Anak {$kelas}{$i}";
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
                    'tahunajar' => $tahunAjar,
                ]);

                $counter++;
            }
        }
    }
}
