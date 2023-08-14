<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\AbsensiCheckIn;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsensiCheckinFactory extends Factory
{
    public function definition()
    {
        $startDate = '2023-08-01';
        $endDate = '2023-08-14';

        // Generate a random time between 07:00 and 09:00 AM
        $jam_masuk = $this->faker->time('H:i', strtotime('07:00:00'), strtotime('09:00:00'));

        // Determine status based on the time
        $status = ($jam_masuk > '08:00:00') ? 'late' : 'ontime';

        return [
            'user_id' => User::factory(),
            'tanggal_presensi' => $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
            'jam_masuk' => $jam_masuk,
            'status' => $status,
        ];
    }
}
