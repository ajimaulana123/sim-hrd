<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'department',
        'position',
        'description',
        'requirements',
        'quota',
        'salary_min',
        'salary_max',
        'employment_type',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    // Relasi
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('status', 'published')
            ->whereDate('end_date', '>=', now());
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function scopeByEmploymentType($query, $type)
    {
        return $query->where('employment_type', $type);
    }

    // Accessor
    public function getSalaryRangeAttribute()
    {
        return number_format($this->salary_min, 0) . ' - ' . number_format($this->salary_max, 0);
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date < now();
    }
}
