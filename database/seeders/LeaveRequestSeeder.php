<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $managers = Employee::whereHas('position', function ($query) {
            $query->where('name', 'like', '%Manager%');
        })->get();

        foreach ($employees as $employee) {
            $numRequests = rand(1, 3);
            
            for ($i = 0; $i < $numRequests; $i++) {
                $startDate = now()->addDays(rand(1, 60));
                $duration = rand(1, 5);
                $endDate = $startDate->copy()->addDays($duration - 1);
                $type = ['annual', 'sick', 'unpaid'][rand(0, 2)];
                $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
                
                $data = [
                    'employee_id' => $employee->id,
                    'type' => $type,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_days' => $duration,
                    'reason' => $this->getRandomReason($type),
                    'status' => $status,
                ];

                if ($status !== 'pending') {
                    $data['approved_by'] = $managers->random()->id;
                    $data['approved_at'] = now()->subDays(rand(1, 7));
                    
                    if ($status === 'rejected') {
                        $data['rejection_reason'] = $this->getRandomRejectionReason();
                    }
                }

                LeaveRequest::create($data);
            }
        }
    }

    private function getRandomReason(string $type): string
    {
        return match($type) {
            'annual' => [
                'Family vacation',
                'Personal time off',
                'Attending a wedding',
                'Religious holiday',
                'Home renovation'
            ][rand(0, 4)],
            'sick' => [
                'Fever and flu',
                'Medical check-up',
                'Dental appointment',
                'Not feeling well',
                'Recovery from injury'
            ][rand(0, 4)],
            'unpaid' => [
                'Extended family matter',
                'Personal development',
                'Overseas trip',
                'Family emergency',
                'Important personal business'
            ][rand(0, 4)],
            default => 'Other personal reasons',
        };
    }

    private function getRandomRejectionReason(): string
    {
        return [
            'High workload during requested period',
            'Insufficient leave balance',
            'Short notice request',
            'Critical project deadline',
            'Team member already on leave during the period'
        ][rand(0, 4)];
    }
}
