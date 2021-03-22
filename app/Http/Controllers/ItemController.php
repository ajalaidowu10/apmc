<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ItemResource;
use App\Item;

class ItemController extends Controller
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
       return ItemResource::collection(Item::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(ItemRequest $request)
   {
       $item = new Item($request->all());
       $item->save();

       return response(['name' => $item->name], Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
   public function show(Item $item)
   {
      return new ItemResource($item);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
   public function update(ItemRequest $request, Item $item)
   {
       $item->update($request->all());
       return response(['name' => $item->name], Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
   public function destroy(Item $item)
   {
      $item->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }

   
}
