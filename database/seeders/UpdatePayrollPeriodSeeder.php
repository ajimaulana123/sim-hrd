<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdatePayrollPeriodSeeder extends Seeder
{
    public function run()
    {
        DB::statement("UPDATE payrolls SET period = DATE_FORMAT(created_at, '%Y-%m-01') WHERE period IS NULL");
    }
} 