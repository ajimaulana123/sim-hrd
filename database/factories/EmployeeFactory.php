<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
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

        return [
            'employee_id' => 'EMP' . $this->faker->unique()->numberBetween(1001, 9999),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'birth_date' => $this->faker->dateTimeBetween('-40 years', '-20 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'department' => $department,
            'position' => $position,
            'join_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'status' => $this->faker->randomElement(['active', 'probation', 'terminated']),
            'base_salary' => $this->faker->numberBetween(4000000, 15000000),
            'bank_name' => $this->faker->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI']),
            'bank_account' => $this->faker->numerify('##########'),
            'npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            'bpjs_tk' => $this->faker->numerify('##########'),
            'bpjs_kes' => $this->faker->numerify('##########'),
        ];
    }
}
