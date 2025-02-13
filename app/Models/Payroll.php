<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'allowances',
        'deductions',
        'overtime_pay',
        'bonus',
        'tax',
        'bpjs_tk',
        'bpjs_kes',
        'net_salary',
        'notes',
        'status',
        'payment_date'
    ];

    protected $casts = [
        'base_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'bonus' => 'decimal:2',
        'tax' => 'decimal:2',
        'bpjs_tk' => 'decimal:2',
        'bpjs_kes' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'payment_date' => 'date'
    ];

    // Relasi
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Scope
    public function scopeByMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor
    public function getTotalDeductionsAttribute()
    {
        return $this->deductions + $this->tax + $this->bpjs_tk + $this->bpjs_kes;
    }

    public function getTotalEarningsAttribute()
    {
        return $this->base_salary + $this->allowances + $this->overtime_pay + $this->bonus;
    }
}
