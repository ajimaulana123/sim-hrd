<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            $positions = $this->getPositionsForDepartment($department->code);
            
            foreach ($positions as $position) {
                Position::create([
                    'name' => $position['name'],
                    'code' => $department->code . '-' . $position['code'],
                    'description' => $position['description'],
                    'salary_min' => $position['salary_min'],
                    'salary_max' => $position['salary_max'],
                    'department_id' => $department->id,
                ]);
            }
        }
    }

    private function getPositionsForDepartment(string $code): array
    {
        return match($code) {
            'HR' => [
                [
                    'name' => 'HR Manager',
                    'code' => 'MGR',
                    'description' => 'Manages HR department and oversees all HR operations',
                    'salary_min' => 15000000,
                    'salary_max' => 25000000,
                ],
                [
                    'name' => 'HR Specialist',
                    'code' => 'SPEC',
                    'description' => 'Handles recruitment and employee relations',
                    'salary_min' => 8000000,
                    'salary_max' => 15000000,
                ],
                [
                    'name' => 'HR Staff',
                    'code' => 'STAFF',
                    'description' => 'Assists in HR administrative tasks',
                    'salary_min' => 5000000,
                    'salary_max' => 8000000,
                ],
            ],
            'IT' => [
                [
                    'name' => 'IT Manager',
                    'code' => 'MGR',
                    'description' => 'Manages IT department and technical projects',
                    'salary_min' => 18000000,
                    'salary_max' => 30000000,
                ],
                [
                    'name' => 'Senior Developer',
                    'code' => 'SDEV',
                    'description' => 'Leads development team and handles complex programming tasks',
                    'salary_min' => 12000000,
                    'salary_max' => 20000000,
                ],
                [
                    'name' => 'Junior Developer',
                    'code' => 'JDEV',
                    'description' => 'Assists in software development and maintenance',
                    'salary_min' => 6000000,
                    'salary_max' => 10000000,
                ],
            ],
            'FIN' => [
                [
                    'name' => 'Finance Manager',
                    'code' => 'MGR',
                    'description' => 'Manages financial operations and strategy',
                    'salary_min' => 20000000,
                    'salary_max' => 35000000,
                ],
                [
                    'name' => 'Senior Accountant',
                    'code' => 'SACC',
                    'description' => 'Handles complex accounting tasks and financial reporting',
                    'salary_min' => 10000000,
                    'salary_max' => 18000000,
                ],
                [
                    'name' => 'Junior Accountant',
                    'code' => 'JACC',
                    'description' => 'Assists in accounting and bookkeeping',
                    'salary_min' => 5000000,
                    'salary_max' => 9000000,
                ],
            ],
            'MKT' => [
                [
                    'name' => 'Marketing Manager',
                    'code' => 'MGR',
                    'description' => 'Manages marketing strategies and campaigns',
                    'salary_min' => 15000000,
                    'salary_max' => 25000000,
                ],
                [
                    'name' => 'Marketing Specialist',
                    'code' => 'SPEC',
                    'description' => 'Develops and executes marketing campaigns',
                    'salary_min' => 8000000,
                    'salary_max' => 15000000,
                ],
                [
                    'name' => 'Marketing Staff',
                    'code' => 'STAFF',
                    'description' => 'Assists in marketing activities and social media',
                    'salary_min' => 5000000,
                    'salary_max' => 8000000,
                ],
            ],
            'OPS' => [
                [
                    'name' => 'Operations Manager',
                    'code' => 'MGR',
                    'description' => 'Manages daily operations and logistics',
                    'salary_min' => 15000000,
                    'salary_max' => 25000000,
                ],
                [
                    'name' => 'Operations Supervisor',
                    'code' => 'SUPV',
                    'description' => 'Supervises operational activities and staff',
                    'salary_min' => 8000000,
                    'salary_max' => 15000000,
                ],
                [
                    'name' => 'Operations Staff',
                    'code' => 'STAFF',
                    'description' => 'Handles daily operational tasks',
                    'salary_min' => 5000000,
                    'salary_max' => 8000000,
                ],
            ],
            default => [],
        };
    }
}
