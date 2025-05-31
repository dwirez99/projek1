<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Guru::create([
            'name' => 'SITI INNAMANASIROH, S.Pd',
            'position' => 'Kepala Sekolah',
            'image' => 'img/guru1.jpeg',
        ]);

        Guru::create([
            'name' => 'INAYATUL KHUSNA, S.Pd',
            'position' => 'Guru Kelas B',
            'image' => 'img/guru2.jpeg',
        ]);

        Guru::create([
            'name' => "FATIMATUZ ZAHRO' KUSUMA WARDANI, S.Pd",
            'position' => 'Guru Kelas A',
            'image' => 'img/guru3.jpeg',
        ]);

        Guru::create([
            'name' => 'JAMILATUL KHOFAH, S.Ag',
            'position' => 'Guru Kelas B',
            'image' => 'img/guru4.jpeg',
        ]);

        Guru::create([
            'name' => 'FEBRIOLA SAFITRI',
            'position' => 'Guru Kelas A',
            'image' => 'img/guru5.jpeg',
        ]);
    }
}
