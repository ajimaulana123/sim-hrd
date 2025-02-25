<?php

namespace App\Filament\Resources\PerformanceResource\Pages;

use App\Filament\Resources\PerformanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePerformance extends CreateRecord
{
    protected static string $resource = PerformanceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['evaluator_id'] = auth()->user()->employee_id;
        $data['overall_score'] = $this->calculateOverallScore($data);
        
        return $data;
    }

    private function calculateOverallScore(array $data): float
    {
        return round(
            ($data['kpi_achievement'] * 0.3) +
            ($data['quality_of_work'] * 0.15) +
            ($data['efficiency'] * 0.15) +
            ($data['attendance_score'] * 0.1) +
            ($data['teamwork'] * 0.1) +
            ($data['communication'] * 0.1) +
            ($data['initiative'] * 0.05) +
            ($data['leadership'] * 0.05),
            2
        );
    }
} 