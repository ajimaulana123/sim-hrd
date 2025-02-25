<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Attendance;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;

class DepartmentStatsWidget extends ChartWidget
{
    protected static ?string $heading = 'Department Performance';
    protected static ?int $sort = 5;
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        if (auth()->user()->role !== 'admin') {
            return [];
        }

        $departments = Department::withCount('employees')->get();
        $attendanceData = [];

        foreach ($departments as $department) {
            $attendanceRate = Attendance::whereHas('employee', function ($query) use ($department) {
                $query->where('department_id', $department->id);
            })
                ->whereMonth('date', now())
                ->where('status', 'present')
                ->count();

            $attendanceData[] = $attendanceRate;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Employee Count',
                    'data' => $departments->pluck('employees_count')->toArray(),
                    'backgroundColor' => 'rgb(59, 130, 246)', // Blue
                ],
                [
                    'label' => 'Attendance Rate',
                    'data' => $attendanceData,
                    'backgroundColor' => 'rgb(34, 197, 94)', // Green
                ],
            ],
            'labels' => $departments->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
} 