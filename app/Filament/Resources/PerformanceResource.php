<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerformanceResource\Pages;
use App\Models\Performance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PerformanceResource extends Resource
{
    protected static ?string $model = Performance::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Employee Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'first_name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->visible(fn () => auth()->user()->role === 'admin'),

                Forms\Components\DatePicker::make('evaluation_period')
                    ->required()
                    ->label('Period'),

                Forms\Components\DatePicker::make('evaluation_date')
                    ->required()
                    ->default(now()),

                Forms\Components\Section::make('Performance Metrics')
                    ->schema([
                        Forms\Components\TextInput::make('kpi_achievement')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->label('KPI Achievement'),

                        Forms\Components\Slider::make('quality_of_work')
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1)
                            ->label('Quality of Work'),

                        Forms\Components\Slider::make('efficiency')
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1),

                        Forms\Components\Slider::make('attendance_score')
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1),

                        Forms\Components\Slider::make('teamwork')
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1),

                        Forms\Components\Slider::make('communication')
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1),

                        Forms\Components\Slider::make('initiative')
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1),

                        Forms\Components\Slider::make('leadership')
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->step(1),
                    ])->columns(2),

                Forms\Components\Section::make('Feedback & Goals')
                    ->schema([
                        Forms\Components\Textarea::make('strengths')
                            ->rows(3),

                        Forms\Components\Textarea::make('areas_of_improvement')
                            ->rows(3)
                            ->label('Areas for Improvement'),

                        Forms\Components\Textarea::make('goals_for_next_period')
                            ->rows(3),

                        Forms\Components\Textarea::make('comments')
                            ->rows(3),
                    ])->columns(2),

                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'acknowledged' => 'Acknowledged',
                        'archived' => 'Archived',
                    ])
                    ->required()
                    ->default('draft')
                    ->visible(fn () => auth()->user()->role === 'admin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('evaluation_period')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kpi_achievement')
                    ->numeric(2)
                    ->suffix('%')
                    ->sortable(),

                Tables\Columns\TextColumn::make('overall_score')
                    ->numeric(2)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'draft',
                        'warning' => 'submitted',
                        'success' => 'acknowledged',
                        'gray' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'acknowledged' => 'Acknowledged',
                        'archived' => 'Archived',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('acknowledge')
                    ->visible(fn ($record) => 
                        $record->status === 'submitted' && 
                        auth()->user()->employee_id === $record->employee_id
                    )
                    ->action(fn ($record) => $record->update([
                        'status' => 'acknowledged',
                        'acknowledged_at' => now(),
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])->visible(fn () => auth()->user()->role === 'admin'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerformances::route('/'),
            'create' => Pages\CreatePerformance::route('/create'),
            'edit' => Pages\EditPerformance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->role === 'employee') {
            $query->where('employee_id', auth()->user()->employee_id);
        }

        return $query;
    }
} 