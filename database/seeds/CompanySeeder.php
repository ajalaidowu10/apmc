<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(['name' => 'ABC', 'email' => 'abc@softwey.com', 'phone' => '08072156721', 'address' => 'Lagos', 'created_by' => 1]);
    }
}
