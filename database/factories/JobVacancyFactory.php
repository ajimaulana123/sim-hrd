<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobVacancyFactory extends Factory
{
    public function definition(): array
    {
        $departments = ['IT', 'HR', 'Finance', 'Marketing', 'Operations'];
        $positions = [
            'IT' => ['Software Engineer', 'System Admin', 'UI/UX Designer', 'QA Engineer', 'Project Manager'],
            'HR' => ['HR Manager', 'Recruiter', 'HR Specialist', 'Training Coordinator', 'HR Assistant'],
            'Finance' => ['Finance Manager', 'Accountant', 'Financial Analyst', 'Payroll Specialist', 'Tax Consultant'],
            'Marketing' => ['Marketing Manager', 'Digital Marketing', 'Content Writer', 'Brand Manager', 'SEO Specialist'],
            'Operations' => ['Operations Manager', 'Supply Chain', 'Logistics Coordinator', 'Quality Control', 'Production Supervisor'],
        ];

        $department = $this->faker->randomElement($departments);
        $position = $this->faker->randomElement($positions[$department]);
        $salaryMin = $this->faker->numberBetween(4000000, 8000000);

        return [
            'title' => $position . ' - ' . $department . ' Department',
            'department' => $department,
            'position' => $position,
            'description' => $this->faker->paragraphs(3, true),
            'requirements' => "- " . implode("\n- ", $this->faker->sentences(5)),
            'quota' => $this->faker->numberBetween(1, 5),
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMin + $this->faker->numberBetween(2000000, 7000000),
            'employment_type' => $this->faker->randomElement(['full_time', 'part_time', 'contract', 'internship']),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
