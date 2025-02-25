<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveRequestChart extends ChartWidget
{
    protected static ?string $heading = 'Leave Requests';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';
    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        if (auth()->user()->role === 'admin') {
            $data = LeaveRequest::select(
                'type',
                DB::raw('count(*) as count')
            )
                ->whereYear('created_at', now()->year)
                ->groupBy('type')
                ->get();

            $monthlyData = LeaveRequest::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
                ->whereYear('created_at', now()->year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get();

            return [
                'datasets' => [
                    [
                        'label' => 'Leave Requests by Type',
                        'data' => $data->pluck('count')->toArray(),
                        'backgroundColor' => [
                            'rgb(16, 185, 129)',  // Emerald
                            'rgb(59, 130, 246)',  // Blue
                            'rgb(236, 72, 153)',  // Pink
                            'rgb(99, 102, 241)',  // Indigo
                            'rgb(245, 158, 11)',  // Amber
                            'rgb(107, 114, 128)', // Gray
                        ],
                    ],
                    [
                        'label' => 'Monthly Trend',
                        'data' => $monthlyData->pluck('count')->toArray(),
                        'type' => 'line',
                        'borderColor' => 'rgb(59, 130, 246)', // Blue
                        'fill' => false,
                    ],
                ],
                'labels' => $data->pluck('type')->map(function ($type) {
                    return ucfirst($type) . ' Leave';
                })->toArray(),
            ];
        }

        // For employees
        $data = LeaveRequest::select('type', DB::raw('count(*) as count'))
            ->where('employee_id', auth()->user()->employee_id)
            ->whereYear('created_at', now()->year)
            ->groupBy('type')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'My Leave Requests',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => [
                        'rgb(16, 185, 129)',  // Emerald
                        'rgb(59, 130, 246)',  // Blue
                        'rgb(236, 72, 153)',  // Pink
                        'rgb(99, 102, 241)',  // Indigo
                        'rgb(245, 158, 11)',  // Amber
                        'rgb(107, 114, 128)', // Gray
                    ],
                ],
            ],
            'labels' => $data->pluck('type')->map(function ($type) {
                return ucfirst($type) . ' Leave';
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return auth()->user()->role === 'admin' ? 'bar' : 'pie';
    }
} 