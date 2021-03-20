<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\AreaResource;
use App\Area;

class AreaController extends Controller
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
       return AreaResource::collection(Area::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(AreaRequest $request)
   {
       $area = new Area($request->all());
       $area->save();

       return response(['name' => $area->name], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Area  $area
    * @return \Illuminate\Http\Response
    */
   public function show(Area $area)
   {
      return new AreaResource($area);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Area  $area
    * @return \Illuminate\Http\Response
    */
   public function update(AreaRequest $request, Area $area)
   {
       $area->update($request->all());
       return response(['name' => $area->name], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Area  $area
    * @return \Illuminate\Http\Response
    */
   public function destroy(Area $area)
   {
      $area->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }

   
}
