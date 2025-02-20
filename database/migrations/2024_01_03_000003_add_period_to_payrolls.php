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
            if (!Schema::hasColumn('payrolls', 'period')) {
                $table->date('period')->nullable()->after('employee_id');
            }
        });
    }

    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn('period');
        });
    }
}; 