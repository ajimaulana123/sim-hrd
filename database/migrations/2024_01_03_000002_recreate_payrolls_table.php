<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('payrolls');
        
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('period');
            $table->decimal('base_salary', 12, 2);
            $table->decimal('allowances', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('overtime_pay', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('bpjs_tk', 12, 2)->default(0);
            $table->decimal('bpjs_kes', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2);
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'approved', 'paid'])->default('draft');
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}; 