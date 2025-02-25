<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Manages employee relations, recruitment, and HR policies',
            ],
            [
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'Handles all IT infrastructure and software development',
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Manages company finances and accounting',
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Handles marketing strategies and brand management',
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Manages day-to-day business operations',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
