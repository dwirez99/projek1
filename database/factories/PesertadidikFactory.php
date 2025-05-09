<?php

namespace Database\Factories;

use App\Models\Orangtua;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesertadidik>
 */
class PesertadidikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nisn' => $this->faker->unique()->numerify('##########'),
            'idortu' => Orangtua::inRandomOrder()->first()->id ?? 1,
            'namapd' => $this->faker->name,
            'tanggallahir' => $this->faker->date(),
            'jeniskelamin' => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'kelas' => $this->faker->randomElement(['A', 'B']),
            'tahunajar' => $this->faker->randomElement(['2023', '2024']),
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap']),
            'fase' => 'Pondasi',
            'tinggibadan' => $this->faker->numberBetween(100, 120),
            'beratbadan' => $this->faker->numberBetween(13, 24),
        ];
    }
}
