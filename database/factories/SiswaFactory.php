<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = \App\Models\Siswa::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'wali' => $this->faker->name(),
            'ttl' => $this->faker->date(),
            'jnskelamin' => $this->faker->randomElement(['Laki - Laki', 'Perempuan']),
            'kelas' => $this->faker->randomElement(['A', 'B']),
            'thnajar' => $this->faker->randomElement(['2023', '2024']),
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap']),
            'tb' => $this->faker->numberBetween(120, 180),
            'bb' => $this->faker->numberBetween(30, 80),
            'foto' => $this->faker->image('public/storage/foto', 200, 200, null, false),
        ];
    }
}

