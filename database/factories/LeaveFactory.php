<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = clone $startDate;
        $endDate->modify('+' . $this->faker->numberBetween(1, 5) . ' days');

        $status = $this->faker->randomElement(['pending', 'approved', 'rejected']);

        return [
            'type' => $this->faker->randomElement(['annual', 'sick', 'maternity', 'important_reason', 'unpaid']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration' => $startDate->diff($endDate)->days + 1,
            'reason' => $this->faker->paragraph(),
            'attachment_path' => $this->faker->optional(0.3)->randomElement([
                'leaves/medical-certificate.pdf',
                'leaves/supporting-document.pdf',
                'leaves/family-event.pdf'
            ]),
            'status' => $status,
            'approved_by' => $status === 'approved' ? 1 : null,
            'rejection_reason' => $status === 'rejected' ? $this->faker->sentence() : null,
        ];
    }
}
