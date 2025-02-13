<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'notes',
        'location_in',
        'location_out',
        'ip_address',
        'device'
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    // Relasi
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Scope
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor
    public function getWorkingHoursAttribute()
    {
        if ($this->clock_in && $this->clock_out) {
            return $this->clock_out->diffInHours($this->clock_in);
        }
        return 0;
    }
}
