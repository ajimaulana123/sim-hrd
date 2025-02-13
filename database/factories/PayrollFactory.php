<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    public function definition(): array
    {
        $baseSalary = $this->faker->numberBetween(4000000, 15000000);
        $allowances = $this->faker->numberBetween(500000, 2000000);
        $overtimePay = $this->faker->optional(0.7)->numberBetween(200000, 1000000);
        $bonus = $this->faker->optional(0.3)->numberBetween(500000, 3000000);

        $grossSalary = $baseSalary + $allowances + ($overtimePay ?? 0) + ($bonus ?? 0);
        $tax = round($grossSalary * 0.05);
        $bpjsTk = round($baseSalary * 0.02);
        $bpjsKes = round($baseSalary * 0.01);
        $deductions = $this->faker->numberBetween(0, 500000);

        $netSalary = $grossSalary - $tax - $bpjsTk - $bpjsKes - $deductions;

        $date = $this->faker->dateTimeBetween('-3 months', 'now');

        return [
            'month' => $date->format('m'),
            'year' => $date->format('Y'),
            'base_salary' => $baseSalary,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'overtime_pay' => $overtimePay,
            'bonus' => $bonus,
            'tax' => $tax,
            'bpjs_tk' => $bpjsTk,
            'bpjs_kes' => $bpjsKes,
            'net_salary' => $netSalary,
            'notes' => $this->faker->optional(0.3)->sentence(),
            'status' => $this->faker->randomElement(['draft', 'approved', 'paid']),
            'payment_date' => $this->faker->optional(0.7)->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
