<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NarrationRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\NarrationResource;
use App\Narration;
use Auth;

class NarrationController extends Controller
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
       return NarrationResource::collection(Narration::where('company_id', Auth::guard('admin')->user()->company_id)->latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(NarrationRequest $request)
   {
       $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
       $request->merge($company_id);

       $area = new Narration($request->all());
       $area->save();

       return response(['name' => $area->name], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Narration  $area
    * @return \Illuminate\Http\Response
    */
   public function show(Narration $area)
   {
      return new NarrationResource($area);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Narration  $area
    * @return \Illuminate\Http\Response
    */
   public function update(NarrationRequest $request, Narration $area)
   {
       $company_id = ['company_id' => Auth::guard('admin')->user()->company_id];
       $request->merge($company_id);
       
       $area->update($request->all());
       return response(['name' => $area->name], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Narration  $area
    * @return \Illuminate\Http\Response
    */
   public function destroy(Narration $area)
   {
      $area->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }

   
}
