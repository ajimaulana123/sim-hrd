<?php

namespace App\Filament\Resources\PerformanceResource\Pages;

use App\Filament\Resources\PerformanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPerformances extends ListRecords
{
    protected static string $resource = PerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 