<?php

use Illuminate\Database\Seeder;
use App\AccountType;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountType::create(['name' => 'Standard Code']);
        AccountType::create(['name' => 'Customer Account']);
        AccountType::create(['name' => 'Supplier Account']);
        AccountType::create(['name' => 'Bank Account']);
        AccountType::create(['name' => 'Cash in hand']);
        AccountType::create(['name' => 'General Account']);
        AccountType::create(['name' => 'Income Account']);
        AccountType::create(['name' => 'Expenses Account']);
        AccountType::create(['name' => 'Loan Account']);
        AccountType::create(['name' => 'Capital Account']);
        

    }
}
