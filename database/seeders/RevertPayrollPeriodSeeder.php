<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevertPayrollPeriodSeeder extends Seeder
{
    public function run()
    {
        // Pindahkan data dari period ke month dan year
        DB::statement("
            UPDATE payrolls 
            SET month = DATE_FORMAT(period, '%m'),
                year = DATE_FORMAT(period, '%Y')
            WHERE period IS NOT NULL
        ");
    }
} 