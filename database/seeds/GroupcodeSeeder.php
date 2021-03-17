<?php

use Illuminate\Database\Seeder;
use App\Groupcode;

class GroupcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Fixed Assets', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Investment', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Current Assets', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Branch/Divisions', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Misc Expense (Assets)', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Deposits (Assets)', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Loans & Advances (Assets)', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Cash In Hand', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Bank Accounts', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 1, 'name'=>'Sundry Debtor', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 2, 'name'=>'Purchase Account', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 2, 'name'=>'Sales Account', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 2, 'name'=>'Direct Incomes', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 2, 'name'=>'Stock in Hands', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 2, 'name'=>'Direct Expense', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 2, 'name'=>'Indirect Incomes', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 2, 'name'=>'Indirect Expense', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Reserves & Surplus', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Sundry Creditors', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Bank OD A/c', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Secured Loans', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Unsecured Loans', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Duties & Taxes', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Capital Account', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Loans & Liabilities', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Current Liabilities', 'status_id'=> 1, 'created_by'=> 1]);
        Groupcode::create(['parent_groupcode_id' => 3, 'name'=>'Provisions', 'status_id'=> 1, 'created_by'=> 1]);
    }
}
