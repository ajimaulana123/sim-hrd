<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AttendanceTrendWidget extends ChartWidget
{
    protected static ?string $heading = 'Attendance Trend';
    protected static ?int $sort = 6;
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = [
        'default' => 1,
        'sm' => 2,
        'md' => 3,
        'lg' => 4,
    ];

    protected function getData(): array
    {
        $days = collect(range(1, now()->daysInMonth))->map(function ($day) {
            return now()->setDay($day)->format('Y-m-d');
        });

        if (auth()->user()->role === 'admin') {
            $attendanceData = Attendance::select(
                DB::raw('DATE(date) as date'),
                DB::raw('count(*) as count')
            )
                ->whereMonth('date', now())
                ->groupBy('date')
                ->get()
                ->pluck('count', 'date')
                ->toArray();

            return [
                'datasets' => [
                    [
                        'label' => 'Daily Attendance',
                        'data' => $days->map(function ($day) use ($attendanceData) {
                            return $attendanceData[$day] ?? 0;
                        })->toArray(),
                        'borderColor' => 'rgb(59, 130, 246)',
                        'fill' => true,
                        'tension' => 0.4,
                    ],
                ],
                'labels' => $days->map(function ($day) {
                    return Carbon::parse($day)->format('d M');
                })->toArray(),
            ];
        }

        // For employees
        $myAttendance = Attendance::where('employee_id', auth()->user()->employee_id)
            ->whereMonth('date', now())
            ->get()
            ->pluck('status', 'date')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'My Attendance',
                    'data' => $days->map(function ($day) use ($myAttendance) {
                        return isset($myAttendance[$day]) ? 1 : 0;
                    })->toArray(),
                    'borderColor' => 'rgb(34, 197, 94)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $days->map(function ($day) {
                return Carbon::parse($day)->format('d M');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
} 