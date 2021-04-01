<?php

use Illuminate\Database\Seeder;
use App\FinancialYear;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinancialYear::create(['company_id' => 1, 'from_date'=> '2021-03-01', 'to_date' => '2022-03-30', 'created_by' => 1]);
    }
}
