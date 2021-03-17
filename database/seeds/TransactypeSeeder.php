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
        Transactype::create(['name' => 'Online Booking']);
        Transactype::create(['name' => 'Room Sales']);
        Transactype::create(['name' => 'Cash Bank']);
        Transactype::create(['name' => 'Journal']);
        Transactype::create(['name' => 'Restuarant Sales']);
        Transactype::create(['name' => 'Service Sales']);


    }
}
