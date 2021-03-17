<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['name'=>'Active']);
        Status::create(['name'=>'Inactive']);
        Status::create(['name'=>'Not Confirmed']);
        Status::create(['name'=>'Confirmed']);
        Status::create(['name'=>'Check in']);
        Status::create(['name'=>'Check out']);
    }
}
