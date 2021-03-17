<?php

use Illuminate\Database\Seeder;
use App\ParentGroupcode;

class ParentGroupcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParentGroupcode::create(['name' => 'Assets']);
        ParentGroupcode::create(['name' => 'Profit and Loss']);
        ParentGroupcode::create(['name' => 'Liabilities']);
    }
}
