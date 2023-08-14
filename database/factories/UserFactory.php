<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Default password for all users (you can change this)
            'no_presensi' => $this->faker->unique()->numberBetween(1000, 9999),
            'asal_instansi' => $this->faker->company,
            'nama_unit_kerja' => $this->faker->company,
            'jenis_kelamin' => $this->faker->randomElement(['Male', 'Female']),
            'tanggal_lahir' => $this->faker->date,
            'role' => 'user', // Default role for all users (you can change this)
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
