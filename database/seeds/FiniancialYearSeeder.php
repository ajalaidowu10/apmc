<?php

use Illuminate\Database\Seeder;
use App\FiniancialYear;

class FiniancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FiniancialYear::create(['company_id' => 1, 'from'=> '2021-03-01', 'to' => '2022-03-30', 'created_by' => 1]);
    }
}
