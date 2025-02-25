<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\Department;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EmployeeStatusWidget extends ChartWidget
{
    protected static ?string $heading = 'Employee Distribution';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        if (auth()->user()->role !== 'admin') {
            return [];
        }

        $departmentData = Employee::select('departments.name', DB::raw('count(*) as count'))
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->groupBy('departments.name')
            ->get();

        $statusData = Employee::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'By Department',
                    'data' => $departmentData->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgb(245, 158, 11)', // Amber
                        'rgb(59, 130, 246)', // Blue
                        'rgb(16, 185, 129)', // Emerald
                        'rgb(99, 102, 241)', // Indigo
                        'rgb(244, 63, 94)',  // Rose
                    ],
                ],
                [
                    'label' => 'By Status',
                    'data' => $statusData->pluck('count')->toArray(),
                    'type' => 'line',
                    'borderColor' => 'rgb(239, 68, 68)', // Red
                    'fill' => false,
                ],
            ],
            'labels' => $departmentData->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
} 