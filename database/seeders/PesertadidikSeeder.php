<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesertaDidik;

class PesertaDidikSeeder extends Seeder
{
    public function run(): void
    {
        PesertaDidik::factory()->count(5)->create();
    }
}