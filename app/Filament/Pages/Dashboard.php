<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AttendanceChart;
use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\LeaveRequestChart;
use App\Filament\Widgets\EmployeeStatusWidget;
use App\Filament\Widgets\DepartmentStatsWidget;
use App\Filament\Widgets\AttendanceTrendWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Log;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = -2;
    
    public function getHeaderWidgets(): array
    {
        try {
            return [
                DashboardStatsOverview::class,
            ];
        } catch (\Exception $e) {
            Log::error('Dashboard header widgets error: ' . $e->getMessage());
            return [];
        }
    }

    public function getWidgets(): array
    {
        try {
            if (auth()->user()->role === 'admin') {
                return [
                    AttendanceChart::class,
                    LeaveRequestChart::class,
                    EmployeeStatusWidget::class,
                    DepartmentStatsWidget::class,
                    AttendanceTrendWidget::class,
                ];
            }

            return [
                AttendanceChart::class,
                LeaveRequestChart::class,
                AttendanceTrendWidget::class,
            ];
        } catch (\Exception $e) {
            Log::error('Dashboard widgets error: ' . $e->getMessage());
            return [];
        }
    }
}