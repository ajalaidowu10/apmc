<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FinancialYearRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\FinancialYearResource;
use App\FinancialYear;
use Auth;

class FinancialYearController extends Controller
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
       return FinancialYearResource::collection(FinancialYear::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(FinancialYearRequest $request)
   {
       $created_by = ['created_by' => Auth::guard('admin')->user()->id];
       $request->merge($created_by);

       $finyear = new FinancialYear($request->all());
       $finyear->save();

       return response(['name' => $finyear->from_date." ".$finyear->to_date], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\FinancialYear  $finyear
    * @return \Illuminate\Http\Response
    */
   public function show(FinancialYear $finyear)
   {
      return new FinancialYearResource($finyear);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\FinancialYear  $finyear
    * @return \Illuminate\Http\Response
    */
   public function update(FinancialYearRequest $request, FinancialYear $finyear)
   {
       $created_by = ['created_by' => Auth::guard('admin')->user()->id];
       $request->merge($created_by);

       $finyear->update($request->all());
       return response(['name' => $finyear->from_date." ".$finyear->to_date], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\FinancialYear  $finyear
    * @return \Illuminate\Http\Response
    */
   public function destroy(FinancialYear $finyear)
   {
      $finyear->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }

   
}
