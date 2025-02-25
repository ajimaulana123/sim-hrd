<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'evaluator_id',
        'evaluation_period',
        'evaluation_date',
        'kpi_achievement',
        'quality_of_work',
        'efficiency',
        'attendance_score',
        'teamwork',
        'communication',
        'initiative',
        'leadership',
        'overall_score',
        'strengths',
        'areas_of_improvement',
        'goals_for_next_period',
        'comments',
        'status',
        'acknowledged_at',
    ];

    protected $casts = [
        'evaluation_period' => 'date',
        'evaluation_date' => 'date',
        'kpi_achievement' => 'decimal:2',
        'quality_of_work' => 'integer',
        'efficiency' => 'integer',
        'attendance_score' => 'integer',
        'teamwork' => 'integer',
        'communication' => 'integer',
        'initiative' => 'integer',
        'leadership' => 'integer',
        'overall_score' => 'decimal:2',
        'acknowledged_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Employee::class, 'evaluator_id');
    }

    public function calculateOverallScore()
    {
        return round(($this->kpi_achievement * 0.3) +
            ($this->quality_of_work * 0.15) +
            ($this->efficiency * 0.15) +
            ($this->attendance_score * 0.1) +
            ($this->teamwork * 0.1) +
            ($this->communication * 0.1) +
            ($this->initiative * 0.05) +
            ($this->leadership * 0.05), 2);
    }
} 