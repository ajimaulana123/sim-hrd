<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-10 days', 'now');
        $clockIn = clone $date;
        $clockIn->setTime(rand(7, 9), rand(0, 59));

        $clockOut = clone $date;
        $clockOut->setTime(rand(16, 18), rand(0, 59));

        $status = $this->faker->randomElement(['present', 'late', 'early_leave']);
        if ($status === 'late') {
            $clockIn->setTime(rand(9, 10), rand(0, 59));
        } elseif ($status === 'early_leave') {
            $clockOut->setTime(rand(14, 16), rand(0, 59));
        }

        return [
            'date' => $date,
            'clock_in' => $clockIn,
            'clock_out' => $clockOut,
            'status' => $status,
            'notes' => $this->faker->optional(0.3)->sentence(),
            'location_in' => 'Office - ' . $this->faker->city(),
            'location_out' => 'Office - ' . $this->faker->city(),
            'ip_address' => $this->faker->ipv4(),
            'device' => $this->faker->randomElement(['Web Browser', 'Mobile App', 'Biometric Device']),
        ];
    }
}
