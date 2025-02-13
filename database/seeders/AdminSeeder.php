<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create employee data for admin
        Employee::create([
            'employee_id' => 'ADM001',
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '08123456789',
            'birth_date' => now()->subYears(25),
            'gender' => 'male',
            'department' => 'Management',
            'position' => 'Administrator',
            'join_date' => now(),
            'status' => 'active',
            'base_salary' => 10000000,
        ]);
    }
} 