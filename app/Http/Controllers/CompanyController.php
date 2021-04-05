<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\CompanyResource;
use App\Company;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Account;
use App\Ledger;

class CompanyController extends Controller
{  

    function __construct()
    {
      $this->middleware('JWT', ['except'=> 'index']);
    } 

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       return CompanyResource::collection(Company::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(CompanyRequest $request)
   {
       $created_by = ['created_by' => Auth::guard('admin')->user()->id];
       $request->merge($created_by);

       $company = new Company($request->all());

       $company->save();

        $account = new Account([
                           'account_type_id' => 1, 
                           'name' => 'Sales Account',
                           'opening_bal'=> 0,
                           'crdr_id' => 1,
                           'groupcode_id' => 13,
                           'is_visible' => 0,
                           'company_id' => $company->id,
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
                                       'company_id' => $company->id,
                                   ]);
         $opening_bal->save();
         $account = new Account([
                           'account_type_id' => 1, 
                           'name' => 'Purchase Account',
                           'opening_bal'=> 0,
                           'crdr_id' => 2,
                           'groupcode_id' => 11,
                           'is_visible' => 0,
                           'company_id' => $company->id,
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
                                     'company_id' => $company->id,
                                 ]);
       $opening_bal->save();

       return response(['name' => $company->name], Response::HTTP_CREATED);
   }



   /**
    * Display the specified resource.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
   public function show(Company $company)
   {
      return new CompanyResource($company);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
   public function update(CompanyRequest $request, Company $company)
   {
       $created_by = ['created_by' => Auth::guard('admin')->user()->id];
       $request->merge($created_by);

       $company->update($request->all());
       return response(['name' => $company->name], Response::HTTP_ACCEPTED);
   }

   public function upload(Request $request, Company $company, string $type)
   {
       $created_by = ['created_by' => Auth::guard('admin')->user()->id];
       $request->merge($created_by);
       if (!empty($company->{$type})) {
           if (Storage::exists('public/images/company/' . $company->{$type}))
           {
               Storage::delete('public/images/company/' . $company->{$type});
           }
       }
       $filename = "image-" . time() . '.' . $request->{$type}->getClientOriginalExtension();
       $request->{$type}->move(storage_path('app/public/images/company'), $filename);
       $company->{$type} = $filename;
       $company->save(); 

       return response(['name' => $company->{$type}], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
   public function destroy(Company $company)
   {
      $company->delete();
      Account::where('company_id', $company->id)->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }

   
}
