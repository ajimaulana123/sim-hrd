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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_vacancy_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('cover_letter');
            $table->string('resume_path');
            $table->json('additional_documents')->nullable();
            $table->enum('status', ['pending', 'shortlisted', 'interviewed', 'accepted', 'rejected']);
            $table->text('notes')->nullable();
            $table->timestamp('interview_date')->nullable();
            $table->string('interviewer')->nullable();
            $table->decimal('expected_salary', 12, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
