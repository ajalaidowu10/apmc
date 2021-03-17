<?php

use Illuminate\Database\Seeder;
use App\Crdr;

class CrdrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Crdr::create(['name' => 'Cr']);
        Crdr::create(['name' => 'Dr']);
    }
}
