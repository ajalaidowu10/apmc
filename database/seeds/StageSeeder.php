<?php

use Illuminate\Database\Seeder;
use App\Stage;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stage::create(['name'=>'Booking Stage']);
        Stage::create(['name'=>'Checkin Stage']);
        Stage::create(['name'=>'Checkout Stage']);
    }
}
