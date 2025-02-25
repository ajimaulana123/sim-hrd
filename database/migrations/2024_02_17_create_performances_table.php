<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('employees');
            $table->date('evaluation_period');
            $table->date('evaluation_date');
            $table->decimal('kpi_achievement', 5, 2);
            $table->integer('quality_of_work');
            $table->integer('efficiency');
            $table->integer('attendance_score');
            $table->integer('teamwork');
            $table->integer('communication');
            $table->integer('initiative');
            $table->integer('leadership');
            $table->decimal('overall_score', 5, 2);
            $table->text('strengths')->nullable();
            $table->text('areas_of_improvement')->nullable();
            $table->text('goals_for_next_period')->nullable();
            $table->text('comments')->nullable();
            $table->enum('status', ['draft', 'submitted', 'acknowledged', 'archived'])->default('draft');
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
}; 