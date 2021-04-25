<?php

namespace App\Imports;

use App\Account;
use App\AccountType;
use App\Status;
use App\Crdr;
use App\Groupcode;
use App\Ledger;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;
use DB;


class AccountImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        DB::beginTransaction();
          try 
           {
                $account_type = AccountType::where('name', $row['account_type'])->first();
                $groupcode = Groupcode::where('name', $row['groupcode'])->first();
                $account = new Account([
                            'account_type_id'   => $account_type->id,
                            'name'              => $row['name'],
                            'opening_bal'       => $row['opening_bal'],
                            'crdr_id'           => $row['crdr'] == 'Dr' ? 2 : 1,
                            'groupcode_id'      => $groupcode->id,
                            'phone'             => $row['phone'],
                            'email'             => $row['email'],
                            'bank_name'         => $row['bank_name'],
                            'ifsc_code'         => $row['ifsc_code'],
                            'address_one'       => $row['address_one'],
                            'address_two'       => $row['address_two'],
                            'area'              => $row['area'],
                            'state'             => $row['state'],
                            'zip'               => $row['zip'],
                            'branch'            => $row['branch'],
                            'acct_no'           => $row['acct_no'],
                            'contact_person'    => $row['contact_person'],
                            'credit_days'       => $row['credit_days'],
                            'credit_limit'      => $row['credit_limit'],
                            'status_id'         => 1,
                            'company_id'        => Auth::guard('admin')->user()->company_id,

                        ]);
                $account->save();

                $opening_bal = new Ledger([
                                              'tran_id'        => $account->id, 
                                              'transactype_id' => 1, 
                                              'acct_one_id'    => $account->id,
                                              'acct_two_id'    => $account->id,
                                              'amount'         => $account->opening_bal,
                                              'enter_date'     => Auth::guard('admin')->user()->finyear->from_date,
                                              'crdr_id'        => $account->crdr_id,
                                              'created_by'     => $account->created_by,
                                              'company_id'     => $account->company_id,
                                              'finyear_id'     => Auth::guard('admin')->user()->finyear_id,
                                              'descp'          => $account->name.' '.' Opening Balance of '
                                                                            .$account->opening_bal.' '.$account->crdr->name,
                                              
                                          ]);
                 $opening_bal->save();
           } 
          catch (Exception $e) 
           {
            DB::rollback();
            throw $e;
           }

        DB::commit();

        return $account;
    }
}
