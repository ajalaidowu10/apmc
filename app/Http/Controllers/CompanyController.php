<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\CompanyResource;
use App\Company;
use Illuminate\Support\Facades\Storage;
use Auth;

class CompanyController extends Controller
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
       if (!empty($company->{$type.'_path'})) {
           if (Storage::exists('public/images/company/' . $company->{$type.'_path'}))
           {
               Storage::delete('public/images/company/' . $company->{$type.'_path'});
           }
       }
       $filename = "image-" . time() . '.' . $request->{$type}->getClientOriginalExtension();
       $request->{$type}->move(storage_path('app/public/images/company'), $filename);
       $company->{$type.'_path'} = $filename;
       $company->save(); 

       return response(['name' => $company->name], Response::HTTP_ACCEPTED);
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
      return response(null, Response::HTTP_NO_CONTENT);
   }

   
}
