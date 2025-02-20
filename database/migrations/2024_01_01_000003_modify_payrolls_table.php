<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Hapus kolom month dan year
            $table->dropColumn(['month', 'year']);
            
            // Tambah kolom period
            $table->date('period')->after('employee_id');
        });
    }

    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn('period');
            $table->string('month');
            $table->integer('year');
        });
    }
}; 