<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AttendanceChart extends ChartWidget
{
    protected static ?string $heading = 'Attendance Overview';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        if (auth()->user()->role === 'admin') {
            $data = Attendance::select('status', DB::raw('count(*) as count'))
                ->whereMonth('date', now())
                ->groupBy('status')
                ->get();

            return [
                'datasets' => [
                    [
                        'label' => 'Attendance Status',
                        'data' => $data->pluck('count')->toArray(),
                        'backgroundColor' => [
                            'rgb(34, 197, 94)',   // Green - present
                            'rgb(234, 179, 8)',   // Yellow - late
                            'rgb(249, 115, 22)',  // Orange - early_leave
                            'rgb(239, 68, 68)',   // Red - late_early_leave
                            'rgb(59, 130, 246)',  // Blue - sick
                            'rgb(107, 114, 128)', // Gray - absent
                        ],
                    ],
                ],
                'labels' => $data->pluck('status')->map(function ($status) {
                    return ucfirst(str_replace('_', ' ', $status));
                })->toArray(),
            ];
        }

        // For employees
        $data = Attendance::select('status', DB::raw('count(*) as count'))
            ->where('employee_id', auth()->user()->employee_id)
            ->whereMonth('date', now())
            ->groupBy('status')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'My Attendance',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgb(34, 197, 94)',   // Green - present
                        'rgb(234, 179, 8)',   // Yellow - late
                        'rgb(249, 115, 22)',  // Orange - early_leave
                        'rgb(239, 68, 68)',   // Red - late_early_leave
                        'rgb(59, 130, 246)',  // Blue - sick
                        'rgb(107, 114, 128)', // Gray - absent
                    ],
                ],
            ],
            'labels' => $data->pluck('status')->map(function ($status) {
                return ucfirst(str_replace('_', ' ', $status));
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
} 