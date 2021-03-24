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
                          'name' => 'Sales Account',
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
                          'name' => 'Purchase Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 11,
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
                          'name' => 'Freight Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 1,
                          'groupcode_id' => 19,
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
                          'name' => 'Apmc Bank Account',
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
                         'name' => 'Commission Acount',
                         'opening_bal'=> 0,
                         'crdr_id' => 1,
                         'groupcode_id' => 16,
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
                         'name' => 'Levy Account',
                         'opening_bal'=> 0,
                         'crdr_id' => 2,
                         'groupcode_id' => 19,
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
                          'name' => 'Tolai Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 1,
                          'groupcode_id' => 19,
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
                          'name' => 'Hamali Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 19,
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
                          'name' => 'Vatav Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 19,
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
                          'name' => 'Mktfee Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 19,
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
                          'name' => 'Supfee Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 19,
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
                          'name' => 'Map Levy Account',
                          'opening_bal'=> 0,
                          'crdr_id' => 2,
                          'groupcode_id' => 19,
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
                        'name' => 'Diffrence Account',
                        'opening_bal'=> 0,
                        'crdr_id' => 2,
                        'groupcode_id' => 19,
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
                        'account_type_id' => 12, 
                        'name' => 'Supplier one',
                        'opening_bal'=> 0,
                        'crdr_id' => 2,
                        'groupcode_id' => 19,
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
