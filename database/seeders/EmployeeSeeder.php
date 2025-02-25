<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    private $usedEmails = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::with('positions')->get();
        
        // Create employees for each department
        foreach ($departments as $department) {
            foreach ($department->positions as $position) {
                $count = match($position->code) {
                    $department->code . '-MGR' => 1, // 1 manager per department
                    $department->code . '-SPEC', $department->code . '-SDEV', $department->code . '-SACC', $department->code . '-SUPV' => rand(2, 3), // 2-3 senior/specialist positions
                    default => rand(3, 5), // 3-5 staff/junior positions
                };

                for ($i = 0; $i < $count; $i++) {
                    $gender = rand(0, 1) ? 'male' : 'female';
                    $firstName = $this->getRandomFirstName($gender);
                    $lastName = $this->getRandomLastName();
                    $email = $this->generateUniqueEmail($firstName, $lastName);
                    $joinDate = Carbon::now()->subMonths(rand(1, 36)); // Random join date within last 3 years
                    
                    Employee::create([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => '08' . rand(1, 9) . rand(1000000, 99999999),
                        'gender' => $gender,
                        'birth_date' => Carbon::now()->subYears(rand(20, 50))->format('Y-m-d'),
                        'hire_date' => $joinDate->format('Y-m-d'),
                        'address' => $this->getRandomAddress(),
                        'department_id' => $department->id,
                        'position_id' => $position->id,
                        'salary' => rand($position->salary_min, $position->salary_max),
                        'status' => 'active',
                    ]);
                }
            }
        }
    }

    private function generateUniqueEmail(string $firstName, string $lastName): string
    {
        $baseEmail = strtolower(str_replace(' ', '.', $firstName . '.' . $lastName)) . '@company.com';
        $email = $baseEmail;
        $counter = 1;

        while (in_array($email, $this->usedEmails)) {
            $email = str_replace('@company.com', $counter . '@company.com', $baseEmail);
            $counter++;
        }

        $this->usedEmails[] = $email;
        return $email;
    }

    private function getRandomFirstName(string $gender): string
    {
        $maleNames = ['Budi', 'Agus', 'Dedi', 'Eko', 'Fajar', 'Hendra', 'Irwan', 'Joko', 'Kurniawan', 'Muhammad'];
        $femaleNames = ['Ani', 'Dewi', 'Fitri', 'Indah', 'Lisa', 'Nina', 'Putri', 'Rina', 'Siti', 'Yuni'];
        
        return $gender === 'male' ? $maleNames[array_rand($maleNames)] : $femaleNames[array_rand($femaleNames)];
    }

    private function getRandomLastName(): string
    {
        $lastNames = ['Wijaya', 'Susanto', 'Pratama', 'Saputra', 'Hidayat', 'Nugroho', 'Setiawan', 'Kusuma', 'Putra', 'Santoso'];
        return $lastNames[array_rand($lastNames)];
    }

    private function getRandomAddress(): string
    {
        $streets = ['Jalan Sudirman', 'Jalan Thamrin', 'Jalan Gatot Subroto', 'Jalan Asia Afrika', 'Jalan Diponegoro'];
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Yogyakarta'];
        
        return $streets[array_rand($streets)] . ' No. ' . rand(1, 100) . ', ' . $cities[array_rand($cities)];
    }
}
