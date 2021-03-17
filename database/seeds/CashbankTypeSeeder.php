<?php

use Illuminate\Database\Seeder;
use App\CashbankType;

class CashbankTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CashbankType::create(['name'=>'Receipt']);
        CashbankType::create(['name'=>'Payment']);
    }
}
