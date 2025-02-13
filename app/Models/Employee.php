<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'phone',
        'address',
        'birth_date',
        'join_date',
        'gender',
        'position',
        'department',
        'base_salary',
        'status',
        'bank_name',
        'bank_account',
        'tax_id',
        'bpjs_tk',
        'bpjs_kes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'base_salary' => 'decimal:2',
    ];

    // Relasi ke tabel lain
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    // Accessor
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    // Scope untuk filter
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}
