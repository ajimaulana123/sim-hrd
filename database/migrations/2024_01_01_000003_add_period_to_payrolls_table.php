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
            // Tambah kolom period terlebih dahulu
            $table->date('period')->nullable()->after('employee_id');
            
            // Pindahkan data dari month dan year ke period
            DB::statement("
                UPDATE payrolls 
                SET period = CONCAT(year, '-', LPAD(CASE 
                    WHEN month = 'January' THEN '01'
                    WHEN month = 'February' THEN '02'
                    WHEN month = 'March' THEN '03'
                    WHEN month = 'April' THEN '04'
                    WHEN month = 'May' THEN '05'
                    WHEN month = 'June' THEN '06'
                    WHEN month = 'July' THEN '07'
                    WHEN month = 'August' THEN '08'
                    WHEN month = 'September' THEN '09'
                    WHEN month = 'October' THEN '10'
                    WHEN month = 'November' THEN '11'
                    WHEN month = 'December' THEN '12'
                    ELSE '01'
                END, 2), '-01')
            ");

            // Hapus kolom lama setelah data dipindahkan
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
                SET month = CASE 
                    WHEN MONTH(period) = 1 THEN 'January'
                    WHEN MONTH(period) = 2 THEN 'February'
                    WHEN MONTH(period) = 3 THEN 'March'
                    WHEN MONTH(period) = 4 THEN 'April'
                    WHEN MONTH(period) = 5 THEN 'May'
                    WHEN MONTH(period) = 6 THEN 'June'
                    WHEN MONTH(period) = 7 THEN 'July'
                    WHEN MONTH(period) = 8 THEN 'August'
                    WHEN MONTH(period) = 9 THEN 'September'
                    WHEN MONTH(period) = 10 THEN 'October'
                    WHEN MONTH(period) = 11 THEN 'November'
                    WHEN MONTH(period) = 12 THEN 'December'
                END,
                year = YEAR(period)
            ");

            // Hapus kolom period
            $table->dropColumn('period');
        });
    }
}; 