<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'job_vacancy_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'resume_path',
        'additional_documents',
        'status',
        'notes',
        'interview_date',
        'interviewer',
        'expected_salary'
    ];

    protected $casts = [
        'additional_documents' => 'array',
        'interview_date' => 'datetime',
        'expected_salary' => 'decimal:2'
    ];

    // Relasi
    public function vacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    // Scope
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeScheduledInterview($query)
    {
        return $query->whereNotNull('interview_date')
            ->where('interview_date', '>=', now());
    }

    // Accessor
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'applied' => 'bg-blue-100 text-blue-800',
            'screening' => 'bg-yellow-100 text-yellow-800',
            'interview' => 'bg-purple-100 text-purple-800',
            'test' => 'bg-indigo-100 text-indigo-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getFormattedExpectedSalaryAttribute()
    {
        return number_format($this->expected_salary, 0);
    }
}
