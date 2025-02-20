<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Buat kolom department_id terlebih dahulu
            $table->foreignId('department_id')
                  ->nullable()
                  ->after('position')
                  ->constrained()
                  ->nullOnDelete();

            // Hapus kolom department yang lama jika ada
            if (Schema::hasColumn('employees', 'department')) {
                // Pindahkan data department ke department_id
                DB::statement('UPDATE employees e 
                             JOIN departments d ON e.department = d.name 
                             SET e.department_id = d.id');
                
                $table->dropColumn('department');
            }
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Tambahkan kolom department kembali
            $table->string('department')->nullable();

            // Pindahkan data kembali dari department_id ke department
            DB::statement('UPDATE employees e 
                         JOIN departments d ON e.department_id = d.id 
                         SET e.department = d.name');

            // Hapus kolom department_id
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
}; 