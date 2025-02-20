<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition()
    {
        return [
            'employee_id' => 'EMP' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'birth_date' => $this->faker->date('Y-m-d', '-20 years'),
            'join_date' => $this->faker->date('Y-m-d', '-2 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'position' => $this->faker->jobTitle,
            'department_id' => Department::inRandomOrder()->first()->id ?? null,
            'base_salary' => $this->faker->numberBetween(3000000, 10000000),
            'status' => 'active',
            'bank_name' => $this->faker->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI']),
            'bank_account' => $this->faker->numerify('##########'),
            'tax_id' => $this->faker->numerify('##.###.###.#-###.###'),
            'bpjs_tk' => $this->faker->numerify('##########'),
            'bpjs_kes' => $this->faker->numerify('##########'),
        ];
    }
}
