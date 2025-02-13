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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department');
            $table->string('position');
            $table->text('description');
            $table->text('requirements');
            $table->integer('quota');
            $table->decimal('salary_min', 12, 2);
            $table->decimal('salary_max', 12, 2);
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'internship']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
