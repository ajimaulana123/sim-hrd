<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Hapus kolom period
            if (Schema::hasColumn('payrolls', 'period')) {
                $table->dropColumn('period');
            }

            // Tambah kolom month dan year seperti awal
            $table->string('month')->nullable()->after('employee_id');
            $table->integer('year')->nullable()->after('month');
        });
    }

    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Hapus kolom month dan year
            $table->dropColumn(['month', 'year']);
            
            // Tambah kembali kolom period
            $table->date('period')->nullable()->after('employee_id');
        });
    }
}; 