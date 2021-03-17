<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Ledger;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = new Account([
                          'account_type_id' => 1, 
                          'name' => 'Room Sales Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 1,
                          'groupcode_id' => 13,
                          'is_visible' => 0,
                      ]);
        $account->save();
        $opening_bal = new Ledger([
                                      'tran_id' => $account->id, 
                                      'transactype_id' => 1, 
                                      'acct_one_id' => $account->id,
                                      'acct_two_id' => $account->id,
                                      'amount' => 0,
                                      'enter_date' => $account->created_at,
                                      'crdr_id' => $account->crdr_id,
                                      'descp' => $account->name.' '.' Opening Balance of '
                                                .$account->opening_bal.' '.$account->crdr->name,
                                  ]);
        $opening_bal->save();
        $account = new Account([
                          'account_type_id' => 1, 
                          'name' => 'Room Expense Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 15,
                          'is_visible' => 0,
                      ]);
        $account->save();
        $opening_bal = new Ledger([
                                    'tran_id' => $account->id, 
                                    'transactype_id' => 1, 
                                    'acct_one_id' => $account->id,
                                    'acct_two_id' => $account->id,
                                    'amount' => 0,
                                    'enter_date' => $account->created_at,
                                    'crdr_id' => $account->crdr_id,
                                    'descp' => $account->name.' '.' Opening Balance of '
                                              .$account->opening_bal.' '.$account->crdr->name,
                                ]);
      $opening_bal->save();

        $account = new Account([
                          'account_type_id' => 1, 
                          'name' => 'GST Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 1,
                          'groupcode_id' => 23,
                          'is_visible' => 0,
                      ]);
        $account->save();
        $opening_bal = new Ledger([
                                    'tran_id' => $account->id, 
                                    'transactype_id' => 1, 
                                    'acct_one_id' => $account->id,
                                    'acct_two_id' => $account->id,
                                    'amount' => 0,
                                    'enter_date' => $account->created_at,
                                    'crdr_id' => $account->crdr_id,
                                    'descp' => $account->name.' '.' Opening Balance of '
                                              .$account->opening_bal.' '.$account->crdr->name,
                                ]);
      $opening_bal->save();

        $account = new Account([
                          'account_type_id' => 4, 
                          'name' => 'RED STONE RESORT HDFC BANK',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 9,
                          'is_visible' => 0,
                      ]);
        $account->save();
        $opening_bal = new Ledger([
                                    'tran_id' => $account->id, 
                                    'transactype_id' => 1, 
                                    'acct_one_id' => $account->id,
                                    'acct_two_id' => $account->id,
                                    'amount' => 0,
                                    'enter_date' => $account->created_at,
                                    'crdr_id' => $account->crdr_id,
                                    'descp' => $account->name.' '.' Opening Balance of '
                                              .$account->opening_bal.' '.$account->crdr->name,
                                ]);
      $opening_bal->save();
        $account = new Account([
                         'account_type_id' => 1, 
                         'name' => 'Restaurant Sales Account',
                         'opening_bal'=> 0,
                         'crdr_id' => 1,
                         'groupcode_id' => 13,
                         'is_visible' => 0,
                     ]);
        $account->save();
        $opening_bal = new Ledger([
                                    'tran_id' => $account->id, 
                                    'transactype_id' => 1, 
                                    'acct_one_id' => $account->id,
                                    'acct_two_id' => $account->id,
                                    'amount' => 0,
                                    'enter_date' => $account->created_at,
                                    'crdr_id' => $account->crdr_id,
                                    'descp' => $account->name.' '.' Opening Balance of '
                                              .$account->opening_bal.' '.$account->crdr->name,
                                ]);
      $opening_bal->save();
        $account = new Account([
                         'account_type_id' => 1, 
                         'name' => 'Restaurant Expense Account',
                         'opening_bal'=> 0,
                         'crdr_id' => 2,
                         'groupcode_id' => 15,
                         'is_visible' => 0,
                     ]);
        $account->save();
        $opening_bal = new Ledger([
                                    'tran_id' => $account->id, 
                                    'transactype_id' => 1, 
                                    'acct_one_id' => $account->id,
                                    'acct_two_id' => $account->id,
                                    'amount' => 0,
                                    'enter_date' => $account->created_at,
                                    'crdr_id' => $account->crdr_id,
                                    'descp' => $account->name.' '.' Opening Balance of '
                                              .$account->opening_bal.' '.$account->crdr->name,
                                ]);
      $opening_bal->save();
        $account = new Account([
                          'account_type_id' => 1, 
                          'name' => 'Service Sales Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 1,
                          'groupcode_id' => 13,
                          'is_visible' => 0,
                      ]);
        $account->save();
        $opening_bal = new Ledger([
                                    'tran_id' => $account->id, 
                                    'transactype_id' => 1, 
                                    'acct_one_id' => $account->id,
                                    'acct_two_id' => $account->id,
                                    'amount' => 0,
                                    'enter_date' => $account->created_at,
                                    'crdr_id' => $account->crdr_id,
                                    'descp' => $account->name.' '.' Opening Balance of '
                                              .$account->opening_bal.' '.$account->crdr->name,
                                ]);
      $opening_bal->save();
        $account = new Account([
                          'account_type_id' => 1, 
                          'name' => 'Service Expense Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 15,
                          'is_visible' => 0,
                      ]);
        $account->save();
        $opening_bal = new Ledger([
                                    'tran_id' => $account->id, 
                                    'transactype_id' => 1, 
                                    'acct_one_id' => $account->id,
                                    'acct_two_id' => $account->id,
                                    'amount' => 0,
                                    'enter_date' => $account->created_at,
                                    'crdr_id' => $account->crdr_id,
                                    'descp' => $account->name.' '.' Opening Balance of '
                                              .$account->opening_bal.' '.$account->crdr->name,
                                ]);
      $opening_bal->save();

    }
}
