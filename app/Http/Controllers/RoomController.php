<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\RoomResource;
use App\Room;

class RoomController extends Controller
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
       return RoomResource::collection(Room::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(RoomRequest $request)
   {
       $room = new Room($request->all());
       $room->save();

       return response(['name' => $room->name], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Room  $room
    * @return \Illuminate\Http\Response
    */
   public function show(Room $room)
   {
      return new RoomResource($room);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Room  $room
    * @return \Illuminate\Http\Response
    */
   public function update(RoomRequest $request, Room $room)
   {
       $room->update($request->all());
       return response(['name' => $room->name], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Room  $room
    * @return \Illuminate\Http\Response
    */
   public function destroy(Room $room)
   {
      $room->delete();
      return     ;
   }
}
