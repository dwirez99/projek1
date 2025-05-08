<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrangtuaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'namaortu' => $this->faker->name(),
            'notelportu' => $this->faker->phoneNumber(),
            'emailortu' => $this->faker->unique()->safeEmail(),
        ];
    }
}

