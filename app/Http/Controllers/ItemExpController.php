<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemExpRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ItemExpResource;
use App\ItemExp;
use DB;

class ItemExpController extends Controller
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
       return ItemExpResource::collection(ItemExp::latest()->get());
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(ItemExpRequest $request)
   {
       $itemexp = new ItemExp($request->all());
       $itemexp->save();

       return response(null, Response::HTTP_CREATED);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\ItemExp  $itemexp
    * @return \Illuminate\Http\Response
    */
   public function show(ItemExp $itemexp)
   {
      return new ItemExpResource($itemexp);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\ItemExp  $itemexp
    * @return \Illuminate\Http\Response
    */
   public function update(ItemExpRequest $request, ItemExp $itemexp)
   {
       $itemexp->update($request->all());
       return response(null, Response::HTTP_ACCEPTED);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\ItemExp  $itemexp
    * @return \Illuminate\Http\Response
    */
   public function destroy(ItemExp $itemexp)
   {
      $itemexp->delete();
      return response(null, Response::HTTP_NO_CONTENT);
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function getItemExp(string $enter_date)
   {
       $get_item = ItemExp::where('enter_date', '<=', $enter_date)
                      ->where('status_id', 1)
                      ->orderBy('created_at', 'DESC')
                      ->get()
                      ->unique('item_id');

       return ItemExpResource::collection($get_item);
   }
}
