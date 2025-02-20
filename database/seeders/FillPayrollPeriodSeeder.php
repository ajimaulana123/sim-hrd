<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FillPayrollPeriodSeeder extends Seeder
{
    public function run()
    {
        // Update data yang month dan year masih NULL
        DB::statement("
            UPDATE payrolls 
            SET month = DATE_FORMAT(created_at, '%m'),
                year = DATE_FORMAT(created_at, '%Y')
            WHERE month IS NULL OR year IS NULL
        ");
    }
} 