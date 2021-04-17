<?php

use Illuminate\Database\Seeder;
use App\Transactype;

class TransactypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transactype::create(['name' => 'Opening Balance']);
        Transactype::create(['name' => 'Purchase Entry']);
        Transactype::create(['name' => 'Sales Entry']);
        Transactype::create(['name' => 'Cash Bank']);
        Transactype::create(['name' => 'Journal']);


    }
}
