<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ServiceResource;
use App\Service;

class ServiceController extends Controller
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
       return ServiceResource::collection(Service::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(ServiceRequest $request)
   {
       $service = new Service($request->all());
       $service->save();

       return response(['name' => $service->name], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Service  $service
    * @return \Illuminate\Http\Response
    */
   public function show(Service $service)
   {
      return new ServiceResource($service);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Service  $service
    * @return \Illuminate\Http\Response
    */
   public function update(ServiceRequest $request, Service $service)
   {
       $service->update($request->all());
       return response(['name' => $service->name], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Service  $service
    * @return \Illuminate\Http\Response
    */
   public function destroy(Service $service)
   {
      $service->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }
   
}
