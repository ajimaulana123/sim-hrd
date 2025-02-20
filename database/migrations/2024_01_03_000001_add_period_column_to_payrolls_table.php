<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Tambah kolom period sementara
            $table->date('period')->nullable()->after('employee_id');
            
            // Pindahkan data dari month dan year ke period
            DB::statement("
                UPDATE payrolls 
                SET period = CONCAT(year, '-', LPAD(month, 2, '0'), '-01')
                WHERE month IS NOT NULL AND year IS NOT NULL
            ");

            // Hapus kolom lama
            $table->dropColumn(['month', 'year']);
        });
    }

    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Tambah kolom lama
            $table->string('month')->nullable();
            $table->integer('year')->nullable();

            // Pindahkan data kembali
            DB::statement("
                UPDATE payrolls 
                SET month = DATE_FORMAT(period, '%m'),
                    year = DATE_FORMAT(period, '%Y')
                WHERE period IS NOT NULL
            ");

            // Hapus kolom period
            $table->dropColumn('period');
        });
    }
}; 