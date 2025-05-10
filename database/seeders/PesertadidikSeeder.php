<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesertadidik;

class PesertaDidikSeeder extends Seeder
{
    public function run(): void
    {
        Pesertadidik::factory()->count(5)->create();
    }
}