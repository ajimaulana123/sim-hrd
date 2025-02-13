<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('month');
            $table->string('year');
            $table->decimal('base_salary', 12, 2);
            $table->decimal('allowances', 12, 2);
            $table->decimal('deductions', 12, 2);
            $table->decimal('overtime_pay', 12, 2)->nullable();
            $table->decimal('bonus', 12, 2)->nullable();
            $table->decimal('tax', 12, 2);
            $table->decimal('bpjs_tk', 12, 2);
            $table->decimal('bpjs_kes', 12, 2);
            $table->decimal('net_salary', 12, 2);
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'approved', 'paid']);
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
