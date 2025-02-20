<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdatePayrollMonthYearSeeder extends Seeder
{
    public function run()
    {
        // Update data yang month dan year masih NULL
        DB::statement("
            UPDATE payrolls 
            SET month = COALESCE(month, DATE_FORMAT(created_at, '%m')),
                year = COALESCE(year, DATE_FORMAT(created_at, '%Y'))
            WHERE month IS NULL OR year IS NULL
        ");

        // Update data yang month dan year kosong ('')
        DB::statement("
            UPDATE payrolls 
            SET month = DATE_FORMAT(created_at, '%m'),
                year = DATE_FORMAT(created_at, '%Y')
            WHERE month = '' OR year = ''
        ");
    }
} 