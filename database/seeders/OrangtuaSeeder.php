<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orangtua;

class OrangtuaSeeder extends Seeder
{
    public function run(): void
    {
        Orangtua::factory()->count(4)->create();
    }
}

