<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Log;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = [
        'default' => 1,
        'sm' => 2,
        'md' => 3,
        'lg' => 4,
    ];

    protected function getStats(): array
    {
        try {
            if (auth()->user()->role === 'admin') {
                $totalEmployees = cache()->remember('total_employees', 300, function () {
                    return Employee::count();
                });
                
                $activeEmployees = cache()->remember('active_employees', 300, function () {
                    return Employee::where('status', 'active')->count();
                });
                
                $onLeaveEmployees = cache()->remember('on_leave_employees', 300, function () {
                    return Employee::where('status', 'on_leave')->count();
                });
                
                $todayAttendance = cache()->remember('today_attendance', 60, function () {
                    return Attendance::whereDate('date', today())->count();
                });

                return [
                    Stat::make('Total Employees', $totalEmployees)
                        ->description($activeEmployees . ' active, ' . $onLeaveEmployees . ' on leave')
                        ->descriptionIcon('heroicon-m-user-group')
                        ->color('success'),
                        
                    Stat::make('Today\'s Attendance', $todayAttendance)
                        ->description('Employees present today')
                        ->descriptionIcon('heroicon-m-calendar')
                        ->color('info'),
                        
                    Stat::make('Pending Leave Requests', 
                        cache()->remember('pending_leaves', 60, function () {
                            return LeaveRequest::where('status', 'pending')->count();
                        }))
                        ->description('Click to review')
                        ->descriptionIcon('heroicon-m-clock')
                        ->color('warning'),
                ];
            }

            // For employees
            $employee = Employee::find(auth()->user()->employee_id);
            if (!$employee) {
                Log::error('Employee not found for user: ' . auth()->id());
                return [];
            }

            $monthlyAttendance = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now())
                ->count();

            return [
                Stat::make('My Attendance', $monthlyAttendance)
                    ->description('This month\'s attendance')
                    ->descriptionIcon('heroicon-m-calendar')
                    ->color('success'),
                    
                Stat::make('Leave Balance', '12 days')
                    ->description('Remaining leave days')
                    ->descriptionIcon('heroicon-m-calendar-days')
                    ->color('info'),
                    
                Stat::make('Pending Requests',
                    LeaveRequest::where('employee_id', $employee->id)
                        ->where('status', 'pending')
                        ->count())
                    ->description('Awaiting approval')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),
            ];
        } catch (\Exception $e) {
            Log::error('Stats widget error: ' . $e->getMessage());
            return [];
        }
    }
} 