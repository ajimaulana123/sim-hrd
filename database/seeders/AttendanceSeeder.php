<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now();

        foreach ($employees as $employee) {
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                // Skip weekends
                if ($currentDate->isWeekend()) {
                    $currentDate->addDay();
                    continue;
                }

                // 90% chance of attendance
                if (rand(1, 100) <= 90) {
                    // Random clock in between 7:00 - 9:00
                    $clockIn = $currentDate->copy()->setHour(rand(7, 8))->setMinute(rand(0, 59));
                    
                    // Random work duration between 8-9 hours
                    $workHours = rand(8 * 3600, 9 * 3600); // Convert to seconds
                    $clockOut = $clockIn->copy()->addSeconds($workHours);

                    // Add some randomness to being late or early
                    $isLate = rand(1, 100) <= 20; // 20% chance of being late
                    $isEarlyLeave = rand(1, 100) <= 10; // 10% chance of leaving early

                    if ($isLate) {
                        $clockIn->addMinutes(rand(1, 30)); // 1-30 minutes late
                    }

                    if ($isEarlyLeave) {
                        $clockOut = $clockIn->copy()->addHours(rand(6, 7))->addMinutes(rand(0, 59));
                    }

                    // Calculate work hours
                    $workHours = $clockOut->floatDiffInHours($clockIn);

                    // Determine status
                    $status = 'present';
                    if ($isLate && $isEarlyLeave) {
                        $status = 'late_early_leave';
                    } elseif ($isLate) {
                        $status = 'late';
                    } elseif ($isEarlyLeave) {
                        $status = 'early_leave';
                    }

                    Attendance::create([
                        'employee_id' => $employee->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'clock_in' => $clockIn->format('H:i:s'),
                        'clock_out' => $clockOut->format('H:i:s'),
                        'work_hours' => round($workHours, 2),
                        'status' => $status,
                        'notes' => $this->getRandomNotes($status),
                    ]);
                } else {
                    // Create absence record
                    $status = rand(1, 100) <= 70 ? 'sick' : 'absent'; // 70% chance of sick vs absent
                    
                    Attendance::create([
                        'employee_id' => $employee->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'status' => $status,
                        'notes' => $this->getRandomNotes($status),
                    ]);
                }

                $currentDate->addDay();
            }
        }
    }

    private function getRandomNotes(string $status): ?string
    {
        return match($status) {
            'late' => ['Traffic jam', 'Train delayed', 'Car trouble'][array_rand(['Traffic jam', 'Train delayed', 'Car trouble'])],
            'early_leave' => ['Doctor appointment', 'Family emergency', 'Personal matters'][array_rand(['Doctor appointment', 'Family emergency', 'Personal matters'])],
            'late_early_leave' => ['Doctor appointment', 'Family emergency', 'Personal matters'][array_rand(['Doctor appointment', 'Family emergency', 'Personal matters'])],
            'sick' => ['Fever', 'Flu', 'Not feeling well', 'Stomach ache'][array_rand(['Fever', 'Flu', 'Not feeling well', 'Stomach ache'])],
            'absent' => ['Personal leave', 'Family matter', 'Out of town'][array_rand(['Personal leave', 'Family matter', 'Out of town'])],
            default => null,
        };
    }
}
