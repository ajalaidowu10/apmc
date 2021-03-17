<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoomGroupRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\RoomGroupResource;
use App\RoomGroup;

class RoomGroupController extends Controller
{  

    function __construct()
    {
      $this->middleware('JWT', ['except' => ['show']]);
    } 

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       return RoomGroupResource::collection(RoomGroup::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(RoomGroupRequest $request)
   {
       $roomgroup = new RoomGroup($request->all());
       $roomgroup->save();

       return response(['name' => $roomgroup->name], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\RoomGroup  $roomgroup
    * @return \Illuminate\Http\Response
    */
   public function show(RoomGroup $roomgroup)
   {
      return new RoomGroupResource($roomgroup);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\RoomGroup  $roomgroup
    * @return \Illuminate\Http\Response
    */
   public function update(RoomGroupRequest $request, RoomGroup $roomgroup)
   {
       $roomgroup->update($request->all());
       return response(['name' => $roomgroup->name], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\RoomGroup  $roomgroup
    * @return \Illuminate\Http\Response
    */
   public function destroy(RoomGroup $roomgroup)
   {
      $roomgroup->delete();
      return     ;
   }
}
