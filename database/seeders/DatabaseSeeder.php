<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
        ]);

        // Create regular users
        \App\Models\User::factory(5)->create();

        // Create employees
        \App\Models\Employee::factory(20)->create();

        // Create attendances (10 records per employee for the last 10 days)
        \App\Models\Employee::all()->each(function ($employee) {
            \App\Models\Attendance::factory(10)->create([
                'employee_id' => $employee->id,
            ]);
        });

        // Create payrolls (3 months of payroll per employee)
        \App\Models\Employee::all()->each(function ($employee) {
            \App\Models\Payroll::factory(3)->create([
                'employee_id' => $employee->id,
            ]);
        });

        // Create job vacancies
        \App\Models\JobVacancy::factory(20)->create();

        // Create job applications (2-5 applications per vacancy)
        \App\Models\JobVacancy::all()->each(function ($vacancy) {
            \App\Models\JobApplication::factory(rand(2, 5))->create([
                'job_vacancy_id' => $vacancy->id,
            ]);
        });

        // Create leaves (2-3 leave requests per employee)
        \App\Models\Employee::all()->each(function ($employee) {
            \App\Models\Leave::factory(rand(2, 3))->create([
                'employee_id' => $employee->id,
            ]);
        });
    }
}
