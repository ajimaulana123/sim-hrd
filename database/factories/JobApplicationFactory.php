<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'cover_letter' => $this->faker->paragraphs(3, true),
            'resume_path' => 'resumes/dummy-resume-' . $this->faker->uuid() . '.pdf',
            'additional_documents' => $this->faker->optional(0.3)->randomElements([
                'certificates/cert1.pdf',
                'certificates/cert2.pdf',
                'portfolio/portfolio.pdf'
            ], $this->faker->numberBetween(1, 3)),
            'status' => $this->faker->randomElement(['pending', 'shortlisted', 'interviewed', 'accepted', 'rejected']),
            'notes' => $this->faker->optional(0.5)->paragraph(),
            'interview_date' => $this->faker->optional(0.4)->dateTimeBetween('now', '+2 weeks'),
            'interviewer' => $this->faker->optional(0.4)->name(),
            'expected_salary' => $this->faker->numberBetween(4000000, 15000000),
        ];
    }
}
