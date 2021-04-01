<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AccountRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\AccountResource;
use App\Account;
use App\Ledger;
use Auth;

class AccountController extends Controller
{  

    function __construct()
    {
      $this->middleware('JWT');
    } 

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       return AccountResource::collection(Account::latest()->get());
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function getAccount(int $payment_type_id = 0, int $account_type_id = 0, int $account_id = 0, int $groupcode_id = 0)
   {
       $get_account = Account::latest();

       if ($payment_type_id == 1) 
       {
           $get_account = $get_account->where('account_type_id', 5);
       }


       if ($payment_type_id == 2) 
       {
           $get_account = $get_account->where('account_type_id', 4);
       } 

       if ($account_type_id != 0) 
       {
           if ($account_type_id == 4) 
           {
               $get_account = $get_account->whereIn('account_type_id', [4,5]);
           }else{
              $get_account = $get_account->where('account_type_id', $account_type_id);
           } 
           
       } 


       if ($account_id != 0) 
       {
           $get_account = $get_account->where('id', $account_id);
       } 

       if ($groupcode_id != 0) 
       {
           $get_account = $get_account->where('groupcode_id', $groupcode_id);
       } 

       $get_account = $get_account->get();


       return AccountResource::collection($get_account);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(AccountRequest $request)
   {
       $created_by = ['created_by' => Auth::guard('admin')->user()->id];
       $request->merge($created_by);
       $account = new Account($request->all());
       $account->save();

        $opening_bal = new Ledger([
                                     'tran_id'        => $account->id, 
                                     'transactype_id' => 1, 
                                     'acct_one_id'    => $account->id,
                                     'acct_two_id'    => $account->id,
                                     'amount'         => $account->opening_bal,
                                     'enter_date'     => $account->created_at,
                                     'crdr_id'        => $account->crdr_id,
                                     'created_by'     => $account->created_by,
                                     'descp'          => $account->name.' '.' Opening Balance of '
                                                                   .$account->opening_bal.' '.$account->crdr->name,
                                     
                                 ]);
        $opening_bal->save();


       return response(['name' => $account->name], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Account  $account
    * @return \Illuminate\Http\Response
    */
   public function show(Account $account)
   {
      return new AccountResource($account);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Account  $account
    * @return \Illuminate\Http\Response
    */
   public function update(AccountRequest $request, Account $account)
   {
       $created_by = ['created_by' => Auth::guard('admin')->user()->id];
       $request->merge($created_by);
       $account->update($request->all());
       $opening_bal = Ledger::where('tran_id', $account->id)
                              ->where('transactype_id', 1)
                              ->update([
                                    'acct_one_id'    => $account->id,
                                    'acct_two_id'    => $account->id,
                                    'amount'         => $account->opening_bal,
                                    'enter_date'     => $account->created_at,
                                    'crdr_id'        => $account->crdr_id,
                                    'created_by'     => $account->created_by,
                                    'descp'          => $account->name.' '.' Opening Balance of '
                                                                  .$account->opening_bal.' '.$account->crdr->name,
                                    
                                ]);
       return response(['name' => $account->name], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Account  $account
    * @return \Illuminate\Http\Response
    */
   public function destroy(Account $account)
   {
      if (!$account->is_visible) {
        return;
      } 
      $delete_ledger = Ledger::where('tran_id', $account->id)
                              ->where('transactype_id', 1)
                              ->delete();
      $account->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }
}
