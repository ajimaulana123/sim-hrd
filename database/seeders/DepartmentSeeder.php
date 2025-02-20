<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Human Resources', 'description' => 'HR Department'],
            ['name' => 'Finance', 'description' => 'Finance Department'],
            ['name' => 'Production', 'description' => 'Production Department'],
            ['name' => 'Marketing', 'description' => 'Marketing Department'],
            ['name' => 'IT', 'description' => 'Information Technology Department'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
} 