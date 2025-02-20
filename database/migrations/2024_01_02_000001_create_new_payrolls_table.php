<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Buat tabel baru
        Schema::create('new_payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('period');
            $table->decimal('base_salary', 12, 2);
            $table->decimal('allowances', 12, 2)->nullable();
            $table->decimal('deductions', 12, 2)->nullable();
            $table->decimal('overtime_pay', 12, 2)->nullable();
            $table->decimal('bonus', 12, 2)->nullable();
            $table->decimal('tax', 12, 2)->nullable();
            $table->decimal('bpjs_tk', 12, 2)->nullable();
            $table->decimal('bpjs_kes', 12, 2)->nullable();
            $table->decimal('net_salary', 12, 2);
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'approved', 'paid'])->default('draft');
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });

        // Salin data dari tabel lama
        DB::statement("
            INSERT INTO new_payrolls (
                id, employee_id, period, base_salary, allowances, deductions,
                overtime_pay, bonus, tax, bpjs_tk, bpjs_kes, net_salary,
                notes, status, payment_date, created_at, updated_at
            )
            SELECT 
                id, employee_id, period, base_salary, allowances, deductions,
                overtime_pay, bonus, tax, bpjs_tk, bpjs_kes, net_salary,
                notes, status, payment_date, created_at, updated_at
            FROM payrolls
        ");

        // Hapus tabel lama
        Schema::dropIfExists('payrolls');

        // Rename tabel baru
        Schema::rename('new_payrolls', 'payrolls');
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}; 