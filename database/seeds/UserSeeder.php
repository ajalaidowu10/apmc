<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Account;
use App\Ledger;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $account = new Account([
                                'account_type_id' => 2, 
                                'name' => 'Ajala Idowu', 
                                'crdr_id' => 2,
                                'groupcode_id' => 10,
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

      $user = new User([
                          'first_name' => 'Idowu', 
                          'last_name' => 'Ajala', 
                          'phone' => '09088765643', 
                          'email' => 'ajalaidowu10@gmail.com',
                          'password' => 'ajalaidowu321',
                        ]);
      $account->user()
              ->save($user);

    }
}
